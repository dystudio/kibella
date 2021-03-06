define(function (require) {
  // get the kibana/metric_vis module, and make sure that it requires the 'kibana' module if it
  // didn't already
  var module = require('ui/modules').get('kibana/kibi_radar_vis', ['kibana']);
  var d3 = require('d3');
  var colors = require('components/vislib/components/color/seed_colors')();

  module.controller('KbnRadarVisController', function ($scope, $element, $rootScope, Private) {
    var tabifyAggResponse = Private(require('ui/agg_response/tabify/tabify'));

    var data;
    var config;
    var chartVis;
    var margin;
    var width;
    var height;
    var radarHeight;

    //mouse events
    var over = 'ontouchstart' in window ? 'touchstart' : 'mouseover';
    var out = 'ontouchstart' in window ? 'touchend' : 'mouseout';

    // declare data
    var tableGroups = null;

    var svgRoot = $element[0];

    var getColor = function(i) {
      return colors[i] || '#666';
    }

    // set default config
    var _initConfig = function () {
      margin = 20;
      var chartW = width / 3;
      var chartH = width / 3;
      config = {
        w: chartW,
        h: chartH,
        facet: false,
        levels: 5,
        levelScale: 0.85,
        labelScale: 1.0,
        facetPaddingScale: 1.0,
        maxValue: 0,
        radians: 2 * Math.PI,
        polygonAreaOpacity: 0.3,
        polygonStrokeOpacity: 1,
        polygonPointSize: 4,
        legendBoxSize: 10,
        translateX: chartW / 8,
        translateY: chartH / 8,
        paddingX: chartW,
        paddingY: chartH,
        colors: getColor,
        showLevels: true,
        showLevelsLabels: true,
        showAxesLabels: true,
        showAxes: true,
        showLegend: true,
        showVertices: true,
        showPolygons: true
      };

      // initiate main vis component
      chartVis = {
        svg: null,
        tooltip: null,
        levels: null,
        axis: null,
        vertices: null,
        legend: null,
        allAxis: null,
        total: null,
        radius: null
      };
    };


    // adjust config parameters
    var _updateConfig = function () {
      config.maxValue = Math.max(config.maxValue, d3.max(data, function (d) {
        return d3.max(d.axes, function (o) { return o.value; });
      }));
      config.levelScale = $scope.vis.params.addLevelScale;
      config.labelScale = $scope.vis.params.addLabelScale;
      config.levels = $scope.vis.params.addLevelNumber;
      config.w *= config.levelScale;
      config.h *= config.levelScale;
      config.paddingX = config.w * config.levelScale;
      config.paddingY = config.h * config.levelScale;
      config.facet = $scope.vis.params.isFacet;

      // if facet required:
      if (config.facet) {
        width /= data.length;
        height /= data.length;
        config.w /= data.length;
        config.h /= data.length;
        config.paddingX /= (data.length / config.facetPaddingScale);
        config.paddingY /= (data.length / config.facetPaddingScale);
        config.polygonPointSize *= Math.pow(0.9, data.length);
      }
    };


    var _updateDimensions = function () {
      var delta = 18;
      var w = $element.parent().width();
      var h = $element.parent().height();
      if (w) {
        if (w > delta) {
          w -= delta;
        }
        width = w;
      }
      if (h) {
        if (h > delta) {
          h -= delta;
        }
        height = h;
      }
    };

    var _buildCoordinates = function (data) {
      data.forEach(function (group) {
        group.axes.forEach(function (d, i) {
          var sin = Math.sin(i * config.radians / chartVis.totalAxes);
          var cos = Math.cos(i * config.radians / chartVis.totalAxes);
          d.coordinates = { // [x, y] coordinates
            x: config.w / 2 * (1 - (parseFloat(Math.max(d.value, 0)) / config.maxValue) * sin),
            y: config.h / 2 * (1 - (parseFloat(Math.max(d.value, 0)) / config.maxValue) * cos)
          };
        });
      });
    };

    var _buildVisComponents = function () {
      // update vis parameters
      chartVis.allAxis = data[0].axes.map(function (i, j) { return i.axis; });
      chartVis.totalAxes = chartVis.allAxis.length;
      chartVis.radius = Math.min(config.w / 2, config.h / 2);
      var div = d3.select(svgRoot)
        .append('svg')
        .attr('width', width)
        .attr('height', height + margin);

      //create main chartVis svg
      if (config.facet) {
        chartVis.svg = div
          .append('svg').classed('svg-vis', true)
          .attr('width', config.w + config.paddingX)
          .attr('height', config.h + config.paddingY)
          .append('svg:g')
          .attr('transform', 'translate(' + config.translateX + ',' + config.translateY + ')');
      } else {
        chartVis.svg = div.append('svg')
          .attr('width', width)
          .attr('height', height)
          .append('svg:g')
          .attr('transform', 'translate(' + width  / 4 + ',' + height / 8 + ')');
      }

      // create verticesTooltip
      chartVis.verticesTooltip = d3.select('.application')
        .append('div').classed('verticesTooltip', true)
        .attr('opacity', 0)
        .style({
          'position': 'absolute',
          'color': 'black',
          'font-size': '10px',
          'width': '100px',
          'height': 'auto',
          'padding': '5px',
          'border': '2px solid gray',
          'border-radius': '5px',
          'pointer-events': 'none',
          'opacity': '0',
          'background': '#f4f4f4',
          'z-index': '1'
        });

        // create levels
      chartVis.levels = chartVis.svg.selectAll('.levels')
        .append('svg:g').classed('levels', true);

      // create axes
      chartVis.axes = chartVis.svg.selectAll('.axes')
        .append('svg:g').classed('axes', true);

      // create vertices
      chartVis.vertices = chartVis.svg.selectAll('.vertices');

      //Initiate Legend
      chartVis.legend = chartVis.svg.append('svg:g').classed('legend', true)
        .attr('height', config.h / 2)
        .attr('width', config.w / 2)
        .attr('transform', 'translate(' + 0 + ', ' + 1.1 * config.h + ')');
    };

    var _buildSingleLevelLine = function (levelFactor) {
      chartVis.levels
        .data(chartVis.allAxis).enter()
        .append('svg:line').classed('level-lines', true)
        .attr('x1', function (d, i) { return levelFactor * (1 - Math.sin(i * config.radians / chartVis.totalAxes)); })
        .attr('y1', function (d, i) { return levelFactor * (1 - Math.cos(i * config.radians / chartVis.totalAxes)); })
        .attr('x2', function (d, i) { return levelFactor * (1 - Math.sin((i + 1) * config.radians / chartVis.totalAxes)); })
        .attr('y2', function (d, i) { return levelFactor * (1 - Math.cos((i + 1) * config.radians / chartVis.totalAxes)); })
        .attr('transform', 'translate(' + (config.w / 2 - levelFactor) + ', ' + (config.h / 2 - levelFactor) + ')')
        .attr('stroke', 'gray')
        .attr('stroke-width', '0.5px');
    };

    // builds out the levels of the radar chart
    var _buildLevels = function () {
      for (var level = 0; level < config.levels; level++) {
        var levelFactor = chartVis.radius * ((level + 1) / config.levels);
        // build level-lines
        _buildSingleLevelLine(levelFactor);
      }
    };

    var _buildSingleLevelLabel = function (level, levelFactor) {
      chartVis.levels
        .data([1]).enter()
        .append('svg:text').classed('level-labels', true)
        .text((config.maxValue * (level + 1) / config.levels).toFixed(2))
        .attr('x', function (d) { return levelFactor * (1 - Math.sin(0)); })
        .attr('y', function (d) { return levelFactor * (1 - Math.cos(0)); })
        .attr('transform', 'translate(' + (config.w / 2 - levelFactor + 5) + ', ' + (config.h / 2 - levelFactor) + ')')
        .attr('fill', 'gray')
        .attr('font-family', 'sans-serif')
        .attr('font-size', 10 * config.labelScale + 'px');
    };

    // builds out the levels labels
    var _buildLevelsLabels = function () {
      for (var level = 0; level < config.levels; level++) {
        var levelFactor = chartVis.radius * ((level + 1) / config.levels);
        // build level-labels
        _buildSingleLevelLabel(level, levelFactor);
      }
    };


    // builds out the axes
    var _buildAxes = function () {
      chartVis.axes
        .data(chartVis.allAxis).enter()
        .append('svg:line').classed('axis-lines', true)
        .attr('x1', config.w / 2)
        .attr('y1', config.h / 2)
        .attr('x2', function (d, i) { return config.w / 2 * (1 - Math.sin(i * config.radians / chartVis.totalAxes)); })
        .attr('y2', function (d, i) { return config.h / 2 * (1 - Math.cos(i * config.radians / chartVis.totalAxes)); })
        .attr('stroke', 'grey')
        .attr('stroke-width', '1px');
    };
    // builds out the axes labels
    var _buildAxesLabels = function () {
      chartVis.axes
        .data(chartVis.allAxis).enter()
        .append('svg:text').classed('axis-labels', true)
        .text(function (d) { return d; })
        .attr('text-anchor', 'middle')
        .attr('x', function (d, i) { return config.w / 2 * (1 - 1.3 * Math.sin(i * config.radians / chartVis.totalAxes)); })
        .attr('y', function (d, i) { return config.h / 2 * (1 - 1.1 * Math.cos(i * config.radians / chartVis.totalAxes)); })
        .attr('font-family', 'sans-serif')
        .attr('font-size', 11 * config.labelScale + 'px');
    };

    // builds out the legend
    var _buildLegend = function (data) {
      //Create legend squares
      if (config.facet) {
        chartVis.legend.selectAll('.legend-tiles')
          .data(data).enter()
          .append('svg:rect').classed('legend-tiles', true)
          .attr('x', config.w - config.paddingX / 2)
          .attr('y', function (d, i) { return i * 2 * config.legendBoxSize; })
          .attr('width', config.legendBoxSize)
          .attr('height', config.legendBoxSize)
          .attr('fill', function (d, g) { return config.colors(g); });

        //Create text next to squares
        chartVis.legend.selectAll('.legend-labels')
          .data(data).enter()
          .append('svg:text').classed('legend-labels', true)
          .attr('x', config.w  - config.paddingX / 2 + (1.5 * config.legendBoxSize))
          .attr('y', function (d, i) { return i * 2 * config.legendBoxSize; })
          .attr('dy', 0.07 * config.legendBoxSize + 'em')
          .attr('font-size', 11 * config.labelScale + 'px')
          .attr('fill', 'gray')
          .text(function (d) {
            return d.group;
          });
      } else {
        chartVis.legend.selectAll('.legend-tiles')
          .data(data).enter()
          .append('svg:rect').classed('legend-tiles', true)
          .attr('x', config.w + config.w / 4)
          .attr('y', function (d, i) { return i * 2 * config.legendBoxSize - config.h / 2; })
          .attr('width', config.legendBoxSize)
          .attr('height', config.legendBoxSize)
          .on(over, function (d,i) {
            chartVis.svg.selectAll('.polygon-areas') // fade all other polygons out
              .transition(250)
              .attr('fill-opacity', 0.1)
              .attr('stroke-opacity', 0.1);
            d3.select('#polygon_' + i) // focus on active polygon
              .transition(250)
              .attr('fill-opacity', 0.7)
              .attr('stroke-opacity', config.polygonStrokeOpacity);
          })
          .on(out, function () {
            d3.selectAll('.polygon-areas')
              .transition(250)
              .attr('fill-opacity', config.polygonAreaOpacity)
              .attr('stroke-opacity', 1);
          })
          .attr('fill', function (d, g) { return config.colors(g); });

        //Create text next to squares
        chartVis.legend.selectAll('.legend-labels')
          .data(data).enter()
          .append('svg:text').classed('legend-labels', true)
          .attr('x', config.w  + config.w / 4 + (1.5 * config.legendBoxSize))
          .attr('y', function (d, i) { return i * 2 * config.legendBoxSize - config.h / 2; })
          .attr('dy', 0.07 * config.legendBoxSize + 'em')
          .attr('font-size', 11 * config.labelScale + 'px')
          .attr('fill', 'gray')
          .text(function (d) {
            return d.group;
          });
      }
    };

    // show tooltip of vertices
    var _verticesTooltipShow = function (d) {
      chartVis.verticesTooltip.style('opacity', 0.9)
        .html('<strong>Value</strong>: ' + d.value + '<br />')
        .style('left', (d3.event.pageX) + 'px')
        .style('top', (d3.event.pageY) + 'px');
    };

    // hide tooltip of vertices
    var _verticesTooltipHide = function () {
      chartVis.verticesTooltip.style('opacity', 0);
    };

    // builds out the polygon vertices of the dataset
    var _buildVertices = function (data) {
      data.forEach(function (group, g) {
        chartVis.vertices
          .data(group.axes).enter()
          .append('svg:circle')
          .attr('r', config.polygonPointSize)
          .attr('cx', function (d, i) { return d.coordinates.x; })
          .attr('cy', function (d, i) { return d.coordinates.y; })
          .attr('fill', function (d, g) { return config.colors(g); })
          .on(over, _verticesTooltipShow)
          .on(out, _verticesTooltipHide);
      });
    };

    // builds out the polygon areas of the dataset
    var _buildPolygons = function (data) {
      chartVis.vertices
        .data(data).enter()
        .append('svg:polygon').classed('polygon-areas', true)
        .attr('points', function (group) { // build verticesString for each group
          var verticesString = '';
          group.axes.forEach(function (d) { verticesString += d.coordinates.x + ',' + d.coordinates.y + ' '; });
          return verticesString;
        })
        .attr('id', function (d, i) {return 'polygon_' + i;})
        .attr('stroke-width', '2px')
        .attr('stroke', function (d, i) { return config.colors(i); })
        .attr('fill', function (d, i) { return config.colors(i); })
        .attr('fill-opacity', config.polygonAreaOpacity)
        .attr('stroke-opacity', config.polygonStrokeOpacity)
        .on(over, function (d) {
          chartVis.svg.selectAll('.polygon-areas') // fade all other polygons out
          .transition(250)
            .attr('fill-opacity', 0.1)
            .attr('stroke-opacity', 0.1);
          d3.select(this) // focus on active polygon
          .transition(250)
            .attr('fill-opacity', 0.7)
            .attr('stroke-opacity', config.polygonStrokeOpacity);
        })
        .on(out, function () {
          d3.selectAll('.polygon-areas')
            .transition(250)
            .attr('fill-opacity', config.polygonAreaOpacity)
            .attr('stroke-opacity', 1);
        });
    };


    var _buildVis = function (data) {
      _buildVisComponents();
      _buildCoordinates(data);
      var showLevels = $scope.vis.params.addLevel;
      var showLevelsLabels = $scope.vis.params.addLevelLabel;
      var showAxes = $scope.vis.params.addAxe;
      var showAxesLabels = $scope.vis.params.addAxeLabel;
      var showLegend = $scope.vis.params.addLegend;
      var showVertices = $scope.vis.params.addVertice;
      var showPolygons = $scope.vis.params.addPolygon;

      if (showLevels) _buildLevels();
      if (showLevelsLabels) _buildLevelsLabels();
      if (showAxes) _buildAxes();
      if (showAxesLabels) _buildAxesLabels();
      if (showLegend) _buildLegend(data);
      if (showVertices) _buildVertices(data);
      if (showPolygons) _buildPolygons(data);
    };


    var _render = function () {
      d3.select(svgRoot).selectAll('svg').remove();
      if (config.facet) {
        data.forEach(function (d, i) {
          _buildVis([d]); // build svg for each data group

          // override colors
          chartVis.svg.selectAll('.polygon-areas')
            .attr('stroke', config.colors(i))
            .attr('fill', config.colors(i));
          chartVis.svg.selectAll('.polygon-vertices')
            .attr('fill', config.colors(i));
          chartVis.svg.selectAll('.legend-tiles')
            .attr('fill', config.colors(i));
        });
      } else {
        _buildVis(data); // build svg
      }
    };


    var off = $rootScope.$on('change:vis', function () {
      _updateDimensions();
      _initConfig();
      $scope.processTableGroups(tableGroups);
      _updateConfig();
      _render();
    });

    $scope.$on('$destroy', off);

    $scope.processTableGroups = function (tableGroups) {
      tableGroups.tables.forEach(function (table) {
        data = [];
        var cols = table.columns;
        table.rows.forEach(function (row,i) {
          var group = {};
          group.group = row[0];
          var axes = [];
          for (var i = 1; i < row.length; i++) {
            var item = {};
            if(cols[i].aggConfig.params.field)
              item.axis = cols[i].aggConfig.params.field.displayName;
            item.value = row[i];
            axes.push(item);
          }
          group.axes = axes;
          data.push(group);
        });
      });
    };

    $scope.$watch('esResponse', function (resp) {
      if (resp) {
        // $scope.processTableGroups(tabifyAggResponse($scope.vis, resp));
        // var tableGroups = tabifyAggResponse($scope.vis, resp);
        tableGroups = tabifyAggResponse($scope.vis, resp);
        if (tableGroups.tables.length > 0) {
          if (tableGroups.tables[0].columns.length > 2) {
            _updateDimensions();
            _initConfig();
            $scope.processTableGroups(tableGroups);
            _updateConfig();
            _render();
          }
        }
      }
    });
  });
});
