/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/components/Filter.js":
/*!**********************************!*\
  !*** ./src/components/Filter.js ***!
  \**********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _FilterDropdown__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./FilterDropdown */ "./src/components/FilterDropdown.js");

const {
  useState,
  useEffect
} = wp.element;


const isObjectEmpty = object => {
  return object && Object.keys(object).length;
};

const Filter = _ref => {
  let {
    structure,
    initialFilters
  } = _ref;
  const [filters, setFilters] = useState(isObjectEmpty(initialFilters) && initialFilters || {});
  const [submitReady, setSubmitReady] = useState(false);
  const [showReset, setShowReset] = useState(false);
  useEffect(() => {
    if (isObjectEmpty(filters)) {
      setSubmitReady(true);
      setShowReset(true);
    }
  }, [filters]);

  const changeHandler = (name, value) => {
    setShowReset(true);
    setFilters(prevState => ({ ...prevState,
      [name]: value
    }));
  };

  const handleResetClick = () => {
    setFilters({});
    setShowReset(false);
    setSubmitReady(false);
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wif-filter"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    style: {
      marginBottom: "1.875em"
    }
  }, structure === null || structure === void 0 ? void 0 : structure.map((element, i) => {
    if (!element.type) return;

    switch (element.type) {
      case "text":
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
          className: "wif-filter__text"
        }, element === null || element === void 0 ? void 0 : element.content);

      case "dropdown":
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_FilterDropdown__WEBPACK_IMPORTED_MODULE_1__["default"], {
          key: i,
          name: element.name,
          options: element.options,
          changeHandler: changeHandler,
          value: filters[element.name] || null
        });

      default:
        return;
    }
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("button", {
    className: "wif-filter__submit",
    disabled: !submitReady
  }, "Bekijk resultaten"), showReset && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "wif-filter__reset",
    onClick: handleResetClick
  }, "Begin opnieuw")));
};

/* harmony default export */ __webpack_exports__["default"] = (Filter);

/***/ }),

/***/ "./src/components/FilterDropdown.js":
/*!******************************************!*\
  !*** ./src/components/FilterDropdown.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

const {
  useState,
  useRef,
  useEffect
} = wp.element;

const FilterDropdown = _ref => {
  var _getSelectedOptionLab;

  let {
    name,
    options,
    value,
    changeHandler
  } = _ref;
  const ref = useRef(null);
  const [collapsed, setCollapsed] = useState(true); // Order options so selected option is first

  options === null || options === void 0 ? void 0 : options.sort((x, y) => x.value === value ? -1 : y.value === value ? 1 : 0);
  useEffect(() => {
    const handleClickOutside = event => {
      if (ref.current && !ref.current.contains(event.target) && !collapsed) setCollapsed(true);
    };

    document.addEventListener("mousedown", handleClickOutside);
    return () => {
      document.removeEventListener("mousedown", handleClickOutside);
    };
  }, [ref, collapsed]);

  const handleClick = e => {
    setCollapsed(!collapsed);
  };

  const handleOptionClick = value => {
    changeHandler(name, value);
  };

  const getSelectedOption = () => {
    return value && options.find(option => option.value === value);
  };

  const getSelectedOptionLabel = () => {
    const selectedOption = getSelectedOption();
    return selectedOption === null || selectedOption === void 0 ? void 0 : selectedOption.label;
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ref: ref,
    className: "wif-filter__select-container",
    onClick: handleClick
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wif-filter__select"
  }, value && ((_getSelectedOptionLab = getSelectedOptionLabel()) === null || _getSelectedOptionLab === void 0 ? void 0 : _getSelectedOptionLab.toLowerCase()) || (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: "wif-filter__select-placeholder"
  }, "Placeholder")), !collapsed && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "wif-filter__select-dropdown"
  }, options === null || options === void 0 ? void 0 : options.map((option, i) => {
    const classNames = ["wif-filter__select-dropdown-option"];
    if (option.value === value) classNames.push("wif-filter__select-dropdown-option--selected");
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      key: i,
      className: classNames.join(" "),
      onClick: () => handleOptionClick(option.value)
    }, option === null || option === void 0 ? void 0 : option.label.toLowerCase());
  })));
};

/* harmony default export */ __webpack_exports__["default"] = (FilterDropdown);

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_Filter__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/Filter */ "./src/components/Filter.js");

const {
  render
} = wp.element;

const filterContainer = document.getElementById("wif_filter");

if (filterContainer) {
  var _window$wif;

  if ((_window$wif = window.wif) !== null && _window$wif !== void 0 && _window$wif.structure) {
    var _window$wif2;

    render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_Filter__WEBPACK_IMPORTED_MODULE_1__["default"], {
      structure: window.wif.structure,
      initialFilters: (_window$wif2 = window.wif) === null || _window$wif2 === void 0 ? void 0 : _window$wif2.initialFilters
    }), filterContainer);
  }
}
}();
/******/ })()
;
//# sourceMappingURL=main.js.map