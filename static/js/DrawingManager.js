/*******************************************************************************
* Module: DrawingManager.js
* Author: Preeti Patidar
* Date: 31 may 2016
*
* Description:
* This module will add a toolbar to the current map that allows various shapes to be
* drawn/placed on the map.  Once the shapes have been added, clicking on the shape
* allows the shape to be edited.
*
*
* Usage:
*
* myToolbox = new DrawingManagerModule(map, options);
*
* Display toolbar:
*   myToolbox.show();
*
* Hide toolbar:
*   myToolbox.hide();
*
* Last updated by : Preeti 10/10/17
********************************************************************************/
var drawToolButton = ['radious_cont_div'];
var DrawingManagerModule = function(map, options) {
  var h = 10;
  var hd = 'sd';
  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    h = 20;
    hd = 'hd';
    // some code..
  }
  //Global Variables
  var _map = map,
  _shape = null,
  _editShape = null,
  _points = [],
  _editPoints = [],
  _maskLine = null,
  _maskPoints = [],
  _marker = null,
  _polyShape = null,
  _MapMoveHandler = null,
  _maskLineMoveHandler =null,
  _MapClickHandler = null,
  _MapKeyPressHandler = null,
  _MapDoubleClickHandler = null,
  _ShapeDoubleClickHandler = null,
  _ShapeClickHandler = null,
  _InProcess = false,
  _IsFinish = false,
  _toolBarTemplate = '',
  _shapeType = null,
  _pointIndex = null,
  _DragHandleLayer = new Array,
  _editshapehandler = null,
  _circleCenter = null,
  _distance = null,
  _anchorIndex = null,
  _anchorRightIndex = null,
  _anchorLeftIndex = null,
  _currentToolBarElement = null,
  _Cmarker = null,
  _toolBarQueuedImage = null,
  locs = [],
  _circle = null,
  _polygon=null,
  _Shape2ClickHandler = null,
  _GM = google.maps;
  //Default Options
  var _options = {
    shapeType: 'polyline',
    targetLayer: '',
    maskStrokeColor: '#33779E',
    maskFillColor: '#33779E',
    maskStrokeThickness: 2,
    maskStrokeDashArray: 1,
    shapeStrokeColor: '#33779E',
    shapeStrokeThickness: 2,
    shapeFillColor: '#33779E',
    fillOpacity:0.25,
    strokeOpacity:1,
    toolBarPolygonIcon: 'static/selection_tools_images/polygone-inaactive.png',
    toolBarPolygonHoverIcon: 'static/selection_tools_images/polygone-hover.png',
    toolBarPolygonActiveIcon: 'static/selection_tools_images/polygone-hover.png',

    toolBarRectangleIcon: 'static/selection_tools_images/rectangle-inaactive.png',
    toolBarRectangleHoverIcon: 'static/selection_tools_images/rectangle-hover.png',
    toolbarRectangleActiveIcon: 'static/selection_tools_images/rectangle-hover.png',

    toolbarCircleIcon: 'static/selection_tools_images/circle-inaactive.png',
    toolbarCircleHoverIcon: 'static/selection_tools_images/circle-hover.png',
    toolbarCircleActiveIcon: 'static/selection_tools_images/circle-hover.png',


    stopHandleImage: 'static/selection_tools_images/grab.cur',
    dragHandleImage: 'static/selection_tools_images/map_radius_edit_' + hd + '.jpg', // Image for default drag handle
    dragHandleImageActive: 'static/selection_tools_images/map_radius_edit_' + hd + '_active.jpg', // Image for active drag handle
    dragHandleImageHover: 'static/selection_tools_images/map_radius_edit_' + hd + '_hover.jpg', // Image for active drag handle

    dragHandleImageHeight: h, // Height for default and active drag handle image
    dragHandleImageWidth: h, // Width for default and active drag handle image
    dragHandleImageAnchor: new google.maps.Point(5, 5), // Anchor Point for drag handle image
    shapeMaskStrokeColor: '#23bd93', // Line color of shape mask
    shapeMaskFillColor: '#23bd93', // fill color of shape mask (polygon only)
    shapeMaskStrokeThickness: 1, // line width of shape mask
    shapeMaskStrokeDashArray: 1, //'2 2',                                       // dash pattern of shape mask
    geoService: null,
    polygon: null,
    selId: null
  };


  if (options) {
    _LoadOptions(options);
  }

  var mapContainer = map.getDiv(),
  mapDivId = mapContainer.id, //mapContainer.offsetParent.id,
  toolbarId = mapDivId + '_ToolBarContainer';
  _options.selId = toolbarId + '_StopButton';

  (function() {
    var toolbar = document.getElementById('drawingManager');
    toolbar.style.height = 'auto';
  //  toolbar.style.margin = '4px 0 0 0';
    toolbar.style.borderBottom = 'none';

    var createBtn = function(a, b, c, d, e, f, title) {
      var s = d.toLowerCase();
      style = 'display:block;';

      var img = new Image();
      img.src = b;

      img = new Image();
      img.src = c;

      img = new Image();
      img.src = e;

      var clkFun = '"toolBarClick(this, \'{2}\', { shapeType: \'{3}\' });"';

      var params = 'this, \'{2}\', { shapeType: \'{3}\' }';
      var func = 'toolBarClick';

      var btnTemplate = '<a class="box-action tiptip mapControl" id="' + toolbarId + '_{0}Button"  onclick=' + clkFun + '  title="{6}"  params="' + params + '" func="' + func + '" class="enableButton"><img width="15px" src="{1}" style="margin: 0px 0 -4px 0;"></a>';

      return btnTemplate.replace(/\{0\}/g, a).replace(/\{1\}/g, b).replace(/\{2\}/g, c).replace(/\{3\}/g, d).replace(/\{4\}/g, e).replace(/\{5\}/g, f).replace(/\{6\}/g, title);
    };

    _toolBarTemplate += createBtn('Polygon', _options.toolBarPolygonIcon, _options.toolBarPolygonActiveIcon, 'polygon', _options.toolBarPolygonHoverIcon, _options.toolBarPolygonIcon, 'Draw a Shape');
    _toolBarTemplate += createBtn('Rectangle', _options.toolBarRectangleIcon, _options.toolbarRectangleActiveIcon, 'rectangle', _options.toolBarRectangleHoverIcon, _options.toolBarRectangleIcon, 'Draw a Rectangle');
    _toolBarTemplate += createBtn('Circle', _options.toolbarCircleIcon, _options.toolbarCircleActiveIcon, 'circle', _options.toolbarCircleHoverIcon, _options.toolbarCircleIcon, 'Draw A Circle');

    $('#drawingManagerRadiusCount').html('<div style="display: none; margin-left: 5px !important;" id="radious_cont_div"> <input type="text" disabled="disabled" value="0" id="radious_cont" class ="properties-details" style="width:40px"> Miles <a class="box-action tiptip mapControl" href="javascript:void(0)" onclick="RemoveCircle()" >Delete Circle</a>'); //top: -120px; z-index: 1000; position: absolute; left: 300%;
    $('#drawingManagerPolygonRemove').html('<div style="display: none;" id="poly_cont_div"><a class="box-action tiptip mapControl" href="javascript:void(0)" onclick="RemovePloygon()" >Delete Polygon</a>');
    $("#drawingManager").append(_toolBarTemplate);
    _createCSSClass('.BM_Module_DragHandle', '{ cursor:pointer; }');

    function _createCSSClass(selector, style) {
      if (!document.styleSheets) {
        return;
      }

      if (document.getElementsByTagName("head").length == 0) {
        return;
      }

      var stylesheet;
      var mediaType;
      if (document.styleSheets.length > 0) {
        for (i = 0; i < document.styleSheets.length; i++) {
          if (document.styleSheets[i].disabled) {
            continue;
          }
          var media = document.styleSheets[i].media;
          mediaType = typeof media;

          if (mediaType == "string") {
            if (media == "") {
              styleSheet = document.styleSheets[i];
            }
          } else if (mediaType == "object") {
            styleSheet = document.styleSheets[i];
          }

          if (typeof styleSheet != "undefined") {
            break;
          }
        }
      }

      if (typeof styleSheet == "undefined") {
        var styleSheetElement = document.createElement("style");
        styleSheetElement.type = "text/css";

        document.getElementsByTagName("head")[0].appendChild(styleSheetElement);

        for (i = 0; i < document.styleSheets.length; i++) {
          if (document.styleSheets[i].disabled) {
            continue;
          }
          styleSheet = document.styleSheets[i];
        }

        var media = styleSheet.media;
        mediaType = typeof media;
      }

      if (mediaType == "string") {
        for (i = 0; i < styleSheet.rules.length; i++) {
          if (styleSheet.rules[i].selectorText.toLowerCase() == selector.toLowerCase()) {
            styleSheet.rules[i].style.cssText = style;
            return;
          }
        }

        styleSheet.addRule(selector, style);
      } else if (mediaType == "object") {
        for (i = 0; i < styleSheet.cssRules.length; i++) {
          if (typeof(styleSheet.cssRules[i].selectorText) != 'undefined') {
            if (styleSheet.cssRules[i].selectorText.toLowerCase() == selector.toLowerCase()) {
              styleSheet.cssRules[i].style.cssText = style;
              return;
            }
          }
        }

        styleSheet.insertRule(selector + "{" + style + "}", 0);
      }
    }
  })();

  /*********************** Private Methods ****************************/

  function _init() {

    if (_polyShape) {

    } else {
      $('#radious_cont').val(0);
    }
    if (_marker) {
      _marker = null;
      _marker.setMap(null);
    }

    _MapDoubleClickHandler = _GM.event.addListener(_map, 'dblclick', _DoubleClickHandler);
    _MapClickHandler = _GM.event.addListener(_map, 'click', _MapMouseDownHandler);
    _MapKeyPressHandler = _GM.event.addListener(_map, 'keypress', _KeyPressHandler);

    _setMouseCursor("crosshair");
    _maskPoints = [new _GM.LatLng(0, 0), new _GM.LatLng(0, 0)];

    if (_options.shapeType == "circle"){
      var opt = {
        strokeColor: '#808080',
        strokeWeight: _options.shapeStrokeThickness,
        fillColor: '#FFFFFF',
        strokeOpacity:_options.strokeOpacity,
        fillOpacity:_options.fillOpacity

      };
      _maskLine = new _GM.Circle(opt);
      showButtons();
    }
    else {
      var op = {
        strokeColor: _options.maskStrokeColor,
        strokeWeight: _options.maskStrokeThickness,
        path: _maskPoints,
        strokeOpacity:_options.strokeOpacity,
        fillOpacity:_options.fillOpacity
      }
      if(_circle==null)
      hideButtons();
      _maskLine = new _GM.Polyline(op);
    }

    _points = [];
    _InProcess = true;
    _IsFinish= false;
  }

  function _initEdit(_editShape) {

    _editPoints = [];
    if (_editShape.shapeType == 'circle') {
      var center = _editShape.getCenter();
      var distance = (_editShape.getRadius()/1609.34).toFixed(1);
      _editPoints = _BuildCirclePoint(center.lat(),center.lng(), distance);
    }
    else {
      _editPoints = _editShape.getPath().getArray();
    }
    if (_DragHandleLayer != null && _DragHandleLayer.length > 0) {
      for (var i = 0; i < _DragHandleLayer.length; i++) {
        _DragHandleLayer[i].setMap(null);
      }
    }
    _DragHandleLayer = [];
    var lenOffset = 1;
    switch (_editShape.shapeType.toLowerCase()) {
      case 'polygon':
      case 'rectangle':
      var temp = _editPoints;
      _editPoints = [];
      var tempArr = new Array();
      for (var j = 0; j < temp.length; j++) {
        var str = temp[j].lat() + '_' + temp[j].lng();
        if ($.inArray(str, tempArr) == -1) {
          tempArr.push(str);
          _editPoints.push(temp[j]);
        }
      }
      var l = _editPoints.length;
      for (i = 0; i <= (l - lenOffset); i++) {
        var op = {
          position: _editPoints[i],
          draggable: true,
          icon: _options.dragHandleImage,
          height: _options.dragHandleImageHeight,
          width: _options.dragHandleImageWidth,
          anchor: _options.dragHandleImageAnchor,
          typeName: 'BM_Module_DragHandle'
        };
        var dragHandle = new _GM.Marker(op);
        dragHandle.id = i;
        _AddDragHandleEvents(dragHandle, i);
      }
      break;
      case 'circle':
      var l = _editPoints.length;
      for (i = 0; i < l-1; i+=9) {
        var op = {
          position: _editPoints[i],
          draggable: true,
          icon: _options.dragHandleImage,
          height: _options.dragHandleImageHeight,
          width: _options.dragHandleImageWidth,
          anchor: _options.dragHandleImageAnchor,
          typeName: 'BM_Module_DragHandle'
        };
        var dragHandle = new _GM.Marker(op);
        _AddDragHandleEvents(dragHandle, i);
      }
      break;
    }
    _MapKeyPressHandler = _GM.event.addListener(_map, 'keypress', _EditKeyPressHandler);
    mapContainer.onkeyup = _EditKeyPressHandler; //Need to use Javascript onkeyup for delete button to be captured
  }

  function _AddDragHandleEvents(dragHandle, i) {

    _GM.event.addListener(dragHandle, 'dragstart', function() {
      _StartDragHandler(this);
    });
    _GM.event.addListener(dragHandle, 'drag', function() {
      _DragHandler(this);
    });
    _GM.event.addListener(dragHandle, 'dragend', function() {
      _EndDragHandler(this);
    });
    _GM.event.addListener(dragHandle, 'mouseover', function() {
      this.setOptions({
        icon: _options.dragHandleImageHover
      });
    });
    _GM.event.addListener(dragHandle, 'click', _MouseClickDragHandle);
    _GM.event.addListener(dragHandle, 'mouseout', function() {
      this.setOptions({
        icon: _options.dragHandleImage
      });
    });
    dragHandle.setMap(_map);
    //_DragHandleLayer[i]=dragHandle;
    _DragHandleLayer.push(dragHandle);
  }

  function _MapMouseDownHandler(e) {

    var _currentLocation = e.latLng;
    _points.push(_currentLocation);
    _maskPoints[0] = _currentLocation;
    switch (_points.length) {
      case 1:
      _maskPoints[1] = _currentLocation;
      _circleCenter = _currentLocation;
      _maskLine.setMap(_map);
      if(_options.shapeType.toLowerCase() == 'circle')
      {
        _maskLine.setCenter(_circleCenter);
      }
      _polyShape = _maskLine;
      if (_options.shapeType.toLowerCase() == 'circle' || _options.shapeType.toLowerCase() == 'rectangle')
      map.setOptions({
        draggable: false
      });
      _MapMoveHandler = _GM.event.addListener(_map, 'mousemove', _MapMouseMoveHandler); //
      _maskLineMoveHandler = _GM.event.addListener(_maskLine, 'mousemove', _MapMouseMoveHandler);
      break;
      case 2:
          // Hide the toolbar
          $("#mapToolsDropdown").hide();
      switch (_options.shapeType.toLowerCase()) {
        case 'polygon':
        var opt = {
          strokeColor: _options.shapeStrokeColor,
          strokeWeight: _options.shapeStrokeThickness,
          fillColor: _options.shapeFillColor,
          strokeOpacity:_options.strokeOpacity,
          fillOpacity:_options.fillOpacity,
          paths : _points
        };

        _shape = new _GM.Polygon(opt);
        _shape.shapeType = _options.shapeType;
        _polyShape = _shape;
        _shape.setMap(_map);
        _Cmarker = new _GM.Marker({
          position: _circleCenter,
          icon: 'static/selection_tools_images/tick-circle.png',
          width: 35,
          draggable: true,
          zIndex: 99999999
        });
        $('#poly_cont_div').show();
        _Cmarker.setMap(_map);
        _setMouseCursor("crosshair");
        _GM.event.addListener(_Cmarker, 'click', function() {
          _IsFinish = true;
          if(_polygon !=null){
            _polygon.setMap(null);
            _polygon = null;
          }
          _polygon = _polyShape;
          _Dispose();
          e.handled = true;
          processVertex(_polyShape);
          _Cmarker.setMap(null);
          $('#' + toolbarId + '_Stop_HandButton').trigger("click");
        });
        break;
        case 'circle':
        _IsFinish = true;
        _points = _maskPoints;
        _points.shift();
        var p = _points[0];
        _points.push(p);
        _distance = _GetDistance(_circleCenter, _points[17]);
        _drawCircle(_circleCenter,_distance,true);

        map.setOptions({
          draggable: true
        });
        break;
        case 'rectangle':
        _IsFinish = true;
        _drawPolygon(_maskPoints,true);
        $('#' + toolbarId + '_Stop_HandButton').trigger("click");
        map.setOptions({
          draggable: true
        });
        break;
        default:
        throw 'Shape type must be "polygon" or "polyline".';
      }

      break;
      default:
      _maskLine.setPath(_maskPoints);
      if (_shape != null) {
        _shape.setPath(_points);
        _shape.previousPos = _points;
        _shape.shapeType = _options.shapeType;
        _GM.event.addListener(_shape, 'mousemove', _MapMouseMoveHandler);
      }
      break;
    }

    e.handled = true;
  }

  function _MapMouseMoveHandler(e) {
    if(_maskLine !=null &&_maskLine.getMap() != undefined && _InProcess){
      _setMouseCursor("crosshair");
      _tempLocation = e.latLng;
      switch (_options.shapeType.toLowerCase()) {
        case 'rectangle':
        if (_maskPoints.length == 2) {
          _maskPoints.push(_tempLocation);
          _maskPoints.push(_tempLocation);
          _maskPoints.push(_maskPoints[0]);
        }
        _maskPoints[2] = _tempLocation;
        _maskPoints[1] = new _GM.LatLng(_maskPoints[0].lat(), _maskPoints[2].lng());
        _maskPoints[3] = new _GM.LatLng(_maskPoints[2].lat(), _maskPoints[0].lng());
        _maskLine.setPath(_maskPoints);
        break;
        case 'circle':
        distance = _GetDistance(_points[0], _tempLocation);
        _maskPoints = _BuildCirclePoint(_points[0].lat(), _points[0].lng(), distance);
        $('#radious_cont').val(distance.toFixed(2));
        _maskLine.setRadius(parseFloat(distance)*1609.34);
        break;
        default:
        _maskPoints[1] = _tempLocation;
        _maskLine.setPath(_maskPoints);
        break;
      }

      if (_ShapeDoubleClickHandler != null) {
        _GM.event.removeListener(_ShapeDoubleClickHandler);
        _GM.event.removeListener(_ShapeClickHandler);
        _ShapeDoubleClickHandler = null;
        _ShapeClickHandler = null;
      }
      _ShapeDoubleClickHandler = _GM.event.addListener(_maskLine, 'dblclick', _DoubleClickHandler);
      _ShapeClickHandler = _GM.event.addListener(_maskLine, 'click', _MapMouseDownHandler);
      e.handled = true;
    }
  }

  function _setMouseCursor(val) {
    map.setOptions({
      draggableCursor: "url(static/selection_tools_images/cur.png)",
      draggingCursor: "url(static/selection_tools_images/cur.png)"
    });
  }

  function _StartDragHandler(e) {
    e.setOptions({
      icon: _options.dragHandleImageActive
    });
    var handleLocation = e.getPosition();
    for (i = 0; i <= (_editPoints.length - 1); i++) {
      if (handleLocation == _editPoints[i]) {
        _pointIndex = i;
        break;
      }
    }

    switch (_editShape.shapeType.toLowerCase()) {
      case 'circle':
      break;
      case 'rectangle':
      if (_editPoints.length == 4) {
        _editPoints.push(_points[0]);
      }
      switch (_pointIndex) {
        case 0:
        _anchorRightIndex = 1;
        _anchorIndex = 2;
        _anchorLeftIndex = 3;
        break;
        case 1:
        _anchorRightIndex = 2;
        _anchorIndex = 3;
        _anchorLeftIndex = 0;
        break;
        case 2:
        _anchorRightIndex = 1;
        _anchorIndex = 0;
        _anchorLeftIndex = 3;
        break;
        case 3:
        _anchorRightIndex = 2;
        _anchorIndex = 1;
        _anchorLeftIndex = 0;
        break;
      }
      break;
      default:
      break;

    }
  }

  function _MouseClickDragHandle(e) {}

  function _DragHandler(e) {
    var loc = e.getPosition();
    switch (_editShape.shapeType.toLowerCase()) {
      case 'circle':
      var center = _editShape.getCenter();
      distance = _GetDistance(center, loc);
      _editPoints = _BuildCirclePoint(center.lat(), center.lng(), distance);
      _editShape.setRadius(parseFloat(distance)*1609.34);
      _DragHandleLayer[0].setPosition(_editPoints[0]);
      _DragHandleLayer[1].setPosition(_editPoints[9]);
      _DragHandleLayer[2].setPosition(_editPoints[18]);
      _DragHandleLayer[3].setPosition(_editPoints[27]);
      $('#radious_cont').val(distance.toFixed(2));
      break;
      case 'polygon':
      _editPoints[_pointIndex] = loc;
      if (_pointIndex == 0 && _editShape.toString() == '[AdvancedShapes.Polygon]') {
        _editPoints[_editPoints.length - 1] = loc;
      }
      _editShape.setPath(_editPoints);
      break;
      case 'rectangle':
      _editPoints[_pointIndex] = loc;
      _editPoints[_anchorRightIndex] = new _GM.LatLng(_editPoints[_anchorIndex].lat(), _editPoints[_pointIndex].lng());
      _editPoints[_anchorLeftIndex] = new _GM.LatLng(_editPoints[_pointIndex].lat(), _editPoints[_anchorIndex].lng());
      _editPoints[_editPoints.length - 1] = _editPoints[0];
      _editShape.setPath(_editPoints);
      _DragHandleLayer[_anchorRightIndex].setPosition(_editPoints[_anchorRightIndex]);
      _DragHandleLayer[_anchorIndex].setPosition(_editPoints[_anchorIndex]);
      _DragHandleLayer[_anchorLeftIndex].setPosition(_editPoints[_anchorLeftIndex]);
      break;
      default:
      break;
    }

  }

  function _EndDragHandler(e) {
    var loc = e.getPosition();
    _tempLocation = e.getPosition();
    switch (_editShape.shapeType.toLowerCase()) {
      case 'rectangle':
      _editShape.setPath(_editPoints);
      processVertex(_editShape);
      break;
      case 'circle':
      distance = _GetDistance(_editShape.getCenter(), loc);
      $('#radious_cont').val(distance.toFixed(2));
      _editShape.setRadius(parseFloat(distance)*1609.34);
            console.log(parseFloat(distance));
      processCircle(_editShape);
      break;
      default:
      _editShape.setPath(_editPoints);
      processVertex(_editShape);
      break;
    }
    _points = _tempLocation;
    console.log('heeere');

  }

  function _KeyPressHandler(e) {
    if (_getKeycode(e) == '27') {
      _Dispose();
    }
    e.handled = true;
  }

  function _EditKeyPressHandler(e) {
    if (typeof(locs[17]) != 'undefined' && locs[17] != null) {
      _circleCenter = _GetMidPointLocation(locs[17], locs[35]);
      _distance = _GetDistance(_circleCenter, locs[17]);
    }

    if (_getKeycode(e) == '27') {
      _EditDispose();
    } else if (_getKeycode(e) == '46') { //delete key handler
      //_options.targetLayer.remove(_editShape);
      _editShape.setMap(null);
      _EditDispose();
    }

    if (e) {
      e.handled = true;
    }
  }

  function _getKeycode(e) {
    if (window.event) {
      return window.event.keyCode;
    } else if (e.keyCode) {
      return e.keyCode;
    } else if (e.which) {
      return e.which;
    };
  }

  function _DoubleClickHandler(e) {

    _Dispose();

  }

  function _Dispose() {
    if (_marker) {
      _marker.setMap(null);
      _marker = null;

    }

    if (_shapeType && _shapeType.toString() == 'Polygon') {
      if (_points[_points.length - 1].toString() == _points[_points.length - 2].toString()) {
        _points.pop();
      }
      _points.push(_points[0]);
      _Cmarker.setMap(null);
      _shape.setPath(_points);
    }

    if (_shape) {
      _editshapehandler = _GM.event.addListener(_shape, 'click', function(e) {
        if (_InProcess) {
          _MapMouseDownHandler(e);
        } else {
          edit(this);
        }
      });

    }
    //console.log('finish = '+_IsFinish+'in process = '+_InProcess);
    if(_InProcess && !_IsFinish && _shape!=null)
    _shape.setMap(null);
    if (_maskLine != null)
    _maskLine.setMap(null);
    _shape = null;

    _setMouseCursor("url(static/selection_tools_images/grab.cur)");
    if (_ShapeDoubleClickHandler != null) {
      _GM.event.removeListener(_ShapeDoubleClickHandler);
      _GM.event.removeListener(_ShapeClickHandler);
      _ShapeDoubleClickHandler = null;
      _ShapeClickHandler = null;
    }
    _GM.event.removeListener(_MapClickHandler);
    _GM.event.removeListener(_MapMoveHandler);
    _GM.event.removeListener(_maskLineMoveHandler);
    _GM.event.removeListener(_MapKeyPressHandler);
    _GM.event.removeListener(_MapDoubleClickHandler);

    //document.getElementById(toolbarId + '_PolygonButton').style.backgroundImage = 'url(' + _options.toolBarPolygonIcon + ')';
    //document.getElementById(toolbarId + '_RectangleButton').style.backgroundImage = 'url(' + _options.toolBarRectangleIcon + ')';
    //document.getElementById(toolbarId + '_CircleButton').style.backgroundImage = 'url(' + _options.toolbarCircleIcon + ')';
      document.getElementById(toolbarId + '_PolygonButton').innerHTML = '<img width="15px" src="' + _options.toolBarPolygonIcon + '" style="margin: 2px 0 -2px 0;">';
      document.getElementById(toolbarId + '_RectangleButton').innerHTML = '<img width="15px" src="' + _options.toolBarRectangleIcon + '" style="margin: 2px 0 -2px 0;">';
      document.getElementById(toolbarId + '_CircleButton').innerHTML = '<img width="15px" src="' + _options.toolbarCircleIcon + '" style="margin: 2px 0 -2px 0;">';
    _InProcess = false;
    edit.handled = true;

  }

  function _EditDispose() {
    _GM.event.removeListener(_MapKeyPressHandler);
    if (_Cmarker != null)
    _Cmarker.setMap(null);
    mapContainer.onkeyup = null;
    if (_DragHandleLayer != null && _DragHandleLayer.length > 0) {
      for (var i = 0; i < _DragHandleLayer.length; i++) {
        _DragHandleLayer[i].setMap(null);
      }


    }
    _DragHandleLayer = []; //null;
    _editShape = null;

    edit.handled = true;
  }

  function _LoadOptions(options) {
    for (optionName in options) {
      _options[optionName] = options[optionName];
    }
  }

  function _GetDistance(startLocation, endLocation) {

    distance = google.maps.geometry.spherical.computeDistanceBetween(startLocation, endLocation);

    return distance * 0.000621371;
  }

  function _GetArea() {
    p = _maskPoints;
    var a1 = _GetDistance(p[1], p[2]);
    var a2 = _GetDistance(p[2], p[3]);
    area = a1 * a2;
    return area;
  }

  function _GetAreaRectangle() {
    return 0;
    p = _maskPoints;
    var area = 0;
    j = p.length - 1;
    for (var i = 0; i < p.length; i++) {
      area = area + (a1 - a2);
    }
    area = (a1 * a2);
    return Math.abs(area);
  }

  function _GetTotalLength(points) {
    var total = 0;
    var p = points;
    for (var i = 0; i < p.length; i++) {
      if (i == p.length - 1)
      var t = _GetDistance(p[i], p[0]);
      else
      var t = _GetDistance(p[i], p[i + 1]);
      total += t;
    }

    return total;
  }

  function _GetMidPointLocation(startLocation, endLocation) {
    lat1 = startLocation.lat().toRad();
    lon1 = startLocation.lng().toRad();

    lat2 = endLocation.lat().toRad();
    var dLon = (endLocation.lat() - startLocation.lng()).toRad();

    var Bx = Math.cos(lat2) * Math.cos(dLon),
    By = Math.cos(lat2) * Math.sin(dLon);

    lat3 = Math.atan2(Math.sin(lat1) + Math.sin(lat2),
    Math.sqrt((Math.cos(lat1) + Bx) * (Math.cos(lat1) + Bx) + By * By));
    lon3 = lon1 + Math.atan2(By, Math.cos(lat1) + Bx);
    lon3 = (lon3 + 3 * Math.PI) % (2 * Math.PI) - Math.PI; // normalise to -180..+180º

    return new _GM.LatLng(lat3.toDeg(), lon3.toDeg());
  }

  function _getCenterOfCircle(locs) {
    var bounds = new google.maps.LatLngBounds();
    var len = locs.length;
    for (var i = 0; i < len; i++) {
      bounds.extend(locs[i]);
    }
    var center = bounds.getCenter();
    return center;
  }

  function _BuildCirclePoint(latin, lonin, radius) {
    var locs = [],
    lat1 = latin.toRad(),
    lon1 = lonin.toRad(),
    d = radius / 3956;
    for (var x = 0; x <= 360; x += 10) {
      var tc = (x / 90) * Math.PI / 2,
      lat = Math.asin(Math.sin(lat1) * Math.cos(d) + Math.cos(lat1) * Math.sin(d) * Math.cos(tc)),
      lon;

      lat = lat.toDeg();

      if (Math.cos(lat1) == 0) {
        lon = lonin; // endpoint a pole
      } else {
        lon = ((lon1 - Math.asin(Math.sin(tc) * Math.sin(d) / Math.cos(lat1)) + Math.PI) % (2 * Math.PI)) - Math.PI;
      }

      lon = lon.toDeg();
      locs.push(new _GM.LatLng(lat, lon));
    }

    return locs;
  }

  function _drawCircle(center,radius,processData){
    if(_circle !=null){
      _circle.setMap(null);
      _circle = null;
    }

    var opt = {
      strokeColor: _options.shapeStrokeColor, //'#808080',
      strokeWeight: _options.shapeStrokeThickness,
//      fillColor: '#FFFFFF',
        fillColor: _options.shapeFillColor,
      strokeOpacity:_options.strokeOpacity,
      fillOpacity:_options.fillOpacity,
      center : center,
      radius : parseFloat(radius)*1609.34,
    };
    _shape = new _GM.Circle(opt);
    _shape.shapeType = 'circle';
    _shape.setMap(_map);
    _circle = _shape;
    _polyShape = _shape;
    _Dispose();
    if(processData)
    processCircle(_circle);
    _GM.event.addListener(_circle, 'mousemove', _MapMouseMoveHandler);

  };

  function _drawPolygon(_points,processData){
    $('#poly_cont_div').show();
    var opt = {
      strokeColor: _options.shapeStrokeColor,
      strokeWeight: _options.shapeStrokeThickness,
      fillColor: _options.shapeFillColor,
      strokeOpacity:_options.strokeOpacity,
      fillOpacity:_options.fillOpacity,
      paths : _points
    };
    if(_polygon !=null && processData){
      _polygon.setMap(null);
      _polygon = null;
    }
    _points.shift();
    _shape = new _GM.Polygon(opt);
    _shape.shapeType = _options.shapeType;
    _shape.setMap(_map);
    _polygon = _shape;
    _polyShape = _shape;
    _Dispose();
    _GM.event.addListener(_polygon, 'mousemove', _MapMouseMoveHandler);
    if(processData)
    processVertex(_polygon);
  }

  /*********************** Public Methods ****************************/

  //Dispose function
  this.dispose = function() {
    _Dispose();
  };


  //Hide Toolbar
  this.show = function() {
//    document.getElementById(toolbarId).style.visibility = 'visible';
  };
  //current shape
  this.getShape = function() {
    return _polyShape;
  }

  //get circle
  this.getCircle = function() {
    return _circle;
  };

  this.drawCircle = function(center,radius,processData){
    _EditDispose();
    _drawCircle(center,radius,processData);

    var bounds = _circle.getBounds();
    _map.fitBounds(bounds);
  };
  this.RemoveCircle = function(){
    if(_circle !=null){
      _circle.setMap(null);
      _circle = null;
    }
    hideButtons();
    _EditDispose();
  };
  this.RemovePolygon = function(){
    if(_polygon !=null){
      _polygon.setMap(null);
      _polygon = null;
    }
    if(_Cmarker !=null){
      _Cmarker.setMap(null);
      _Cmarker = null;
    }
    $('#poly_cont_div').hide();
    _EditDispose();
  }

  //Draw the Shape
  draw = function(options) {
    if (_InProcess) {
      _Dispose();
      changeToolBarBackground(_currentToolBarElement, _toolBarQueuedImage);
    }
    _EditDispose();
    _LoadOptions(options);
    _init();
  };

  edit = function(shape) {
    if (shape.shapeType != null) {
      _editShape = shape;
      _GM.event.addListener(_editShape, 'dragstart', function() {
        if (_DragHandleLayer != null && _DragHandleLayer.length > 0) {
          for (var i = 0; i < _DragHandleLayer.length; i++) {
            _DragHandleLayer[i].setMap(null);
          }
        }
        _DragHandleLayer = [];

      });
      _editShape.pid = shape.pid;
      _shapeType = shape.shapeType;
      _initEdit(shape);
    }

  };

  //Tool bar background utility
  changeToolBarBackground = function(toolBarElement, backgroundImage) {

    if (!_InProcess) {
      //toolBarElement.style.backgroundImage = 'url(' + backgroundImage + ')';
      toolBarElement.innerHTML = '<img width="15px" src="' + backgroundImage + '" style="margin: 2px 0 -2px 0;">';
    }
  };
  //Tool bar click handler
  toolBarClick = function(toolBarElement, backgroundImage, moduleOptions) {
    _options.selId = toolBarElement.id;
    _EditDispose();
    _Dispose();
    map.setOptions({
      draggable: true
    });
    if (_InProcess && (toolBarElement == _currentToolBarElement)) {
      _Dispose();

    } else if (!_InProcess && (toolBarElement == _currentToolBarElement)) {
      _currentToolBarElement = null;
    } else {
      _currentToolBarElement = toolBarElement;
      _toolBarQueuedImage = backgroundImage;
      changeToolBarBackground(_currentToolBarElement, _toolBarQueuedImage);
      draw(moduleOptions);
    }
  };
  showButtons = function() {
    for (var i in drawToolButton) {
      $('#' + drawToolButton[i]).show();
    }
  };
  hideButtons = function() {
    $('#radious_cont').val(0);
    for (var i in drawToolButton) {
      $('#' + drawToolButton[i]).hide();
    }
  };


};

// extend Number object with methods for converting degrees/radians
Number.prototype.toRad = function() {
  return this * Math.PI / 180;
}
Number.prototype.toDeg = function() {
  return this * 180 / Math.PI;
}
