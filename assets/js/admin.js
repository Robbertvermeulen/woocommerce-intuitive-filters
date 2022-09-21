/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/admin.js":
/*!**********************!*\
  !*** ./src/admin.js ***!
  \**********************/
/***/ (function() {

eval("jQuery(document).ready(function ($) {\n  const addShortCodeToTextArea = name => {\n    const $textarea = $(\".js-editor-textarea\");\n    let value = $textarea.val();\n    let shortCode = [\"{{\"];\n    shortCode.push(name);\n    shortCode.push(\"}}\");\n    const updatedValue = value.trimRight() + \" \" + shortCode.join(\" \");\n    $textarea.val(updatedValue);\n    inActivatePanelTools();\n  };\n\n  const inActivatePanelTools = () => {\n    $(\".js-panel-tool\").hide();\n    $(\".js-panel-option-button-opener\").removeClass(\"active\");\n  };\n\n  $(document).on(\"click\", \".js-panel-option-button-opener[data-tool-type]\", function (e) {\n    e.preventDefault();\n    const target = $(this).data(\"tool-type\");\n    inActivatePanelTools();\n    $(\".js-panel-tool-\" + target).show();\n    $(this).addClass(\"active\");\n  }).on(\"click\", \".js-panel-tool-add-button\", function (e) {\n    e.preventDefault();\n    const $parent = $(this).parents(\".js-panel-tool\");\n    const $dropdown = $parent.find(\".js-panel-tool-dropdown\");\n    const name = $dropdown.val();\n    addShortCodeToTextArea(name);\n  }).on(\"click\", \".js-panel-option-button-add\", function (e) {\n    e.preventDefault();\n    const name = $(this).data(\"tool-type\");\n    addShortCodeToTextArea(name);\n  }).on(\"change\", \".js-category-mode-selector\", function (e) {\n    const mode = $(\"option:selected\", this).data(\"category-mode\");\n    $(\".js-category-mode-element\").hide();\n    $(\".js-category-mode-\" + mode).show();\n  });\n});\n\n//# sourceURL=webpack:///./src/admin.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./src/admin.js"]();
/******/ 	
/******/ })()
;