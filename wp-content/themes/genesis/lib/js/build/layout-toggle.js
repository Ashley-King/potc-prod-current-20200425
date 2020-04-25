!function(t){var e={};function n(r){if(e[r])return e[r].exports;var o=e[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{configurable:!1,enumerable:!0,get:r})},n.r=function(t){Object.defineProperty(t,"__esModule",{value:!0})},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=25)}([function(t,e){!function(){t.exports=this.wp.element}()},function(t,e){!function(){t.exports=this.wp.i18n}()},function(t,e){!function(){t.exports=this.wp.data}()},function(t,e){!function(){t.exports=this.wp.components}()},function(t,e){t.exports=function(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}},function(t,e){!function(){t.exports=this.wp.compose}()},function(t,e){!function(){t.exports=this.wp.plugins}()},function(t,e,n){"use strict";n.d(e,"a",function(){return u});var r=n(4),o=n.n(r),c=n(2);function i(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter(function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable})),n.push.apply(n,r)}return n}
/**
 * Builds new meta for use when saving post data.
 *
 * @since   3.1.3
 * @package Genesis\JS
 * @author  StudioPress
 * @license GPL-2.0-or-later
 */
function u(t,e){var n=Object(c.select)("core/editor").getEditedPostAttribute("meta");return function(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?i(Object(n),!0).forEach(function(e){o()(t,e,n[e])}):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):i(Object(n)).forEach(function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))})}return t}({},Object.keys(n).filter(function(t){return t.startsWith("_genesis")}).reduce(function(t,e){return t[e]=n[e],null===t[e]&&(t[e]=!1),t},{}),o()({},t,e))}},function(t,e){!function(){t.exports=this.wp.apiFetch}()},function(t,e){t.exports=function(t){if(void 0===t)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return t}},function(t,e,n){var r=n(15);t.exports=function(t,e){if("function"!=typeof e&&null!==e)throw new TypeError("Super expression must either be null or a function");t.prototype=Object.create(e&&e.prototype,{constructor:{value:t,writable:!0,configurable:!0}}),e&&r(t,e)}},function(t,e){function n(e){return t.exports=n=Object.setPrototypeOf?Object.getPrototypeOf:function(t){return t.__proto__||Object.getPrototypeOf(t)},n(e)}t.exports=n},function(t,e,n){var r=n(16),o=n(9);t.exports=function(t,e){return!e||"object"!==r(e)&&"function"!=typeof e?o(t):e}},function(t,e){function n(t,e){for(var n=0;n<e.length;n++){var r=e[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(t,r.key,r)}}t.exports=function(t,e,r){return e&&n(t.prototype,e),r&&n(t,r),t}},function(t,e){t.exports=function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}},function(t,e){function n(e,r){return t.exports=n=Object.setPrototypeOf||function(t,e){return t.__proto__=e,t},n(e,r)}t.exports=n},function(t,e){function n(e){return"function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?t.exports=n=function(t){return typeof t}:t.exports=n=function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t},n(e)}t.exports=n},,,,,,,,,function(t,e,n){"use strict";n.r(e);var r=n(14),o=n.n(r),c=n(13),i=n.n(c),u=n(12),s=n.n(u),a=n(11),l=n.n(a),f=n(10),p=n.n(f),b=n(0),y=n(1),O=n(5),h=n(2),j=n(6),g=n(3),d=n(8),m=n.n(d),v=n(7),P=function(t){function e(t){var n;return o()(this,e),(n=s()(this,l()(e).call(this,t))).state={layouts:[]},n}return p()(e,t),i()(e,[{key:"componentDidMount",value:function(){var t=this,e="/genesis/v1/layouts/singular,".concat(this.props.currentPostType,",").concat(this.props.currentPostID);m()({path:e}).then(function(e){for(var n=[{label:Object(y.__)("Default Layout","genesis"),value:""}],r=0,o=Object.keys(e);r<o.length;r++){var c=o[r];n.push({label:e[c].label,value:c})}t.setState({layouts:n})})}},{key:"render",value:function(){var t=this;return Object(b.createElement)(b.Fragment,null,Object(b.createElement)(g.Fill,{name:"GenesisSidebar"},Object(b.createElement)(g.Panel,null,Object(b.createElement)(g.PanelBody,{initialOpen:!0,title:Object(y.__)("Layout","genesis")},this.state.layouts.length?Object(b.createElement)(g.SelectControl,{label:Object(y.__)("Select Layout","genesis"),value:this.props.layout,options:this.state.layouts,onChange:function(e){return t.props.onChange(e)}}):Object(b.createElement)(g.Spinner,null)))))}}]),e}(b.Component),x=Object(O.compose)([Object(h.withSelect)(function(){return{layout:Object(h.select)("core/editor").getEditedPostAttribute("meta")._genesis_layout,currentPostID:Object(h.select)("core/editor").getCurrentPostId(),currentPostType:Object(h.select)("core/editor").getCurrentPostType()}}),Object(h.withDispatch)(function(t){return{onChange:function(e){t("core/editor").editPost({meta:Object(v.a)("_genesis_layout",e)})}}})])(P);Object(j.registerPlugin)("genesis-layout-toggle",{render:x})}]);