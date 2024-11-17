<!doctype html>
<html lang="en">

     
     <style type="text/css">
          .apexcharts-canvas {
               position: relative;
               user-select: none;
               /* cannot give overflow: hidden as it will crop tooltips which overflow outside chart area */
          }
          /* scrollbar is not visible by default for legend, hence forcing the visibility */
          
          .apexcharts-canvas::-webkit-scrollbar {
               -webkit-appearance: none;
               width: 6px;
          }
          
          .apexcharts-canvas::-webkit-scrollbar-thumb {
               border-radius: 4px;
               background-color: rgba(0, 0, 0, .5);
               box-shadow: 0 0 1px rgba(255, 255, 255, .5);
               -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
          }
          
          .apexcharts-inner {
               position: relative;
          }
          
          .apexcharts-text tspan {
               font-family: inherit;
          }
          
          .legend-mouseover-inactive {
               transition: 0.15s ease all;
               opacity: 0.20;
          }
          
          .apexcharts-series-collapsed {
               opacity: 0;
          }
          
          .apexcharts-tooltip {
               border-radius: 5px;
               box-shadow: 2px 2px 6px -4px #999;
               cursor: default;
               font-size: 14px;
               left: 62px;
               opacity: 0;
               pointer-events: none;
               position: absolute;
               top: 20px;
               display: flex;
               flex-direction: column;
               overflow: hidden;
               white-space: nowrap;
               z-index: 12;
               transition: 0.15s ease all;
          }
          
          .apexcharts-tooltip.apexcharts-active {
               opacity: 1;
               transition: 0.15s ease all;
          }
          
          .apexcharts-tooltip.apexcharts-theme-light {
               border: 1px solid #e3e3e3;
               background: rgba(255, 255, 255, 0.96);
          }
          
          .apexcharts-tooltip.apexcharts-theme-dark {
               color: #fff;
               background: rgba(30, 30, 30, 0.8);
          }
          
          .apexcharts-tooltip * {
               font-family: inherit;
          }
          
          .apexcharts-tooltip-title {
               padding: 6px;
               font-size: 15px;
               margin-bottom: 4px;
          }
          
          .apexcharts-tooltip.apexcharts-theme-light .apexcharts-tooltip-title {
               background: #ECEFF1;
               border-bottom: 1px solid #ddd;
          }
          
          .apexcharts-tooltip.apexcharts-theme-dark .apexcharts-tooltip-title {
               background: rgba(0, 0, 0, 0.7);
               border-bottom: 1px solid #333;
          }
          
          .apexcharts-tooltip-text-value,
          .apexcharts-tooltip-text-z-value {
               display: inline-block;
               font-weight: 600;
               margin-left: 5px;
          }
          
          .apexcharts-tooltip-text-z-label:empty,
          .apexcharts-tooltip-text-z-value:empty {
               display: none;
          }
          
          .apexcharts-tooltip-text-value,
          .apexcharts-tooltip-text-z-value {
               font-weight: 600;
          }
          
          .apexcharts-tooltip-marker {
               width: 12px;
               height: 12px;
               position: relative;
               top: 0px;
               margin-right: 10px;
               border-radius: 50%;
          }
          
          .apexcharts-tooltip-series-group {
               padding: 0 10px;
               display: none;
               text-align: left;
               justify-content: left;
               align-items: center;
          }
          
          .apexcharts-tooltip-series-group.apexcharts-active .apexcharts-tooltip-marker {
               opacity: 1;
          }
          
          .apexcharts-tooltip-series-group.apexcharts-active,
          .apexcharts-tooltip-series-group:last-child {
               padding-bottom: 4px;
          }
          
          .apexcharts-tooltip-series-group-hidden {
               opacity: 0;
               height: 0;
               line-height: 0;
               padding: 0 !important;
          }
          
          .apexcharts-tooltip-y-group {
               padding: 6px 0 5px;
          }
          
          .apexcharts-tooltip-candlestick {
               padding: 4px 8px;
          }
          
          .apexcharts-tooltip-candlestick>div {
               margin: 4px 0;
          }
          
          .apexcharts-tooltip-candlestick span.value {
               font-weight: bold;
          }
          
          .apexcharts-tooltip-rangebar {
               padding: 5px 8px;
          }
          
          .apexcharts-tooltip-rangebar .category {
               font-weight: 600;
               color: #777;
          }
          
          .apexcharts-tooltip-rangebar .series-name {
               font-weight: bold;
               display: block;
               margin-bottom: 5px;
          }
          
          .apexcharts-xaxistooltip {
               opacity: 0;
               padding: 9px 10px;
               pointer-events: none;
               color: #373d3f;
               font-size: 13px;
               text-align: center;
               border-radius: 2px;
               position: absolute;
               z-index: 10;
               background: #ECEFF1;
               border: 1px solid #90A4AE;
               transition: 0.15s ease all;
          }
          
          .apexcharts-xaxistooltip.apexcharts-theme-dark {
               background: rgba(0, 0, 0, 0.7);
               border: 1px solid rgba(0, 0, 0, 0.5);
               color: #fff;
          }
          
          .apexcharts-xaxistooltip:after,
          .apexcharts-xaxistooltip:before {
               left: 50%;
               border: solid transparent;
               content: " ";
               height: 0;
               width: 0;
               position: absolute;
               pointer-events: none;
          }
          
          .apexcharts-xaxistooltip:after {
               border-color: rgba(236, 239, 241, 0);
               border-width: 6px;
               margin-left: -6px;
          }
          
          .apexcharts-xaxistooltip:before {
               border-color: rgba(144, 164, 174, 0);
               border-width: 7px;
               margin-left: -7px;
          }
          
          .apexcharts-xaxistooltip-bottom:after,
          .apexcharts-xaxistooltip-bottom:before {
               bottom: 100%;
          }
          
          .apexcharts-xaxistooltip-top:after,
          .apexcharts-xaxistooltip-top:before {
               top: 100%;
          }
          
          .apexcharts-xaxistooltip-bottom:after {
               border-bottom-color: #ECEFF1;
          }
          
          .apexcharts-xaxistooltip-bottom:before {
               border-bottom-color: #90A4AE;
          }
          
          .apexcharts-xaxistooltip-bottom.apexcharts-theme-dark:after {
               border-bottom-color: rgba(0, 0, 0, 0.5);
          }
          
          .apexcharts-xaxistooltip-bottom.apexcharts-theme-dark:before {
               border-bottom-color: rgba(0, 0, 0, 0.5);
          }
          
          .apexcharts-xaxistooltip-top:after {
               border-top-color: #ECEFF1
          }
          
          .apexcharts-xaxistooltip-top:before {
               border-top-color: #90A4AE;
          }
          
          .apexcharts-xaxistooltip-top.apexcharts-theme-dark:after {
               border-top-color: rgba(0, 0, 0, 0.5);
          }
          
          .apexcharts-xaxistooltip-top.apexcharts-theme-dark:before {
               border-top-color: rgba(0, 0, 0, 0.5);
          }
          
          .apexcharts-xaxistooltip.apexcharts-active {
               opacity: 1;
               transition: 0.15s ease all;
          }
          
          .apexcharts-yaxistooltip {
               opacity: 0;
               padding: 4px 10px;
               pointer-events: none;
               color: #373d3f;
               font-size: 13px;
               text-align: center;
               border-radius: 2px;
               position: absolute;
               z-index: 10;
               background: #ECEFF1;
               border: 1px solid #90A4AE;
          }
          
          .apexcharts-yaxistooltip.apexcharts-theme-dark {
               background: rgba(0, 0, 0, 0.7);
               border: 1px solid rgba(0, 0, 0, 0.5);
               color: #fff;
          }
          
          .apexcharts-yaxistooltip:after,
          .apexcharts-yaxistooltip:before {
               top: 50%;
               border: solid transparent;
               content: " ";
               height: 0;
               width: 0;
               position: absolute;
               pointer-events: none;
          }
          
          .apexcharts-yaxistooltip:after {
               border-color: rgba(236, 239, 241, 0);
               border-width: 6px;
               margin-top: -6px;
          }
          
          .apexcharts-yaxistooltip:before {
               border-color: rgba(144, 164, 174, 0);
               border-width: 7px;
               margin-top: -7px;
          }
          
          .apexcharts-yaxistooltip-left:after,
          .apexcharts-yaxistooltip-left:before {
               left: 100%;
          }
          
          .apexcharts-yaxistooltip-right:after,
          .apexcharts-yaxistooltip-right:before {
               right: 100%;
          }
          
          .apexcharts-yaxistooltip-left:after {
               border-left-color: #ECEFF1;
          }
          
          .apexcharts-yaxistooltip-left:before {
               border-left-color: #90A4AE;
          }
          
          .apexcharts-yaxistooltip-left.apexcharts-theme-dark:after {
               border-left-color: rgba(0, 0, 0, 0.5);
          }
          
          .apexcharts-yaxistooltip-left.apexcharts-theme-dark:before {
               border-left-color: rgba(0, 0, 0, 0.5);
          }
          
          .apexcharts-yaxistooltip-right:after {
               border-right-color: #ECEFF1;
          }
          
          .apexcharts-yaxistooltip-right:before {
               border-right-color: #90A4AE;
          }
          
          .apexcharts-yaxistooltip-right.apexcharts-theme-dark:after {
               border-right-color: rgba(0, 0, 0, 0.5);
          }
          
          .apexcharts-yaxistooltip-right.apexcharts-theme-dark:before {
               border-right-color: rgba(0, 0, 0, 0.5);
          }
          
          .apexcharts-yaxistooltip.apexcharts-active {
               opacity: 1;
          }
          
          .apexcharts-yaxistooltip-hidden {
               display: none;
          }
          
          .apexcharts-xcrosshairs,
          .apexcharts-ycrosshairs {
               pointer-events: none;
               opacity: 0;
               transition: 0.15s ease all;
          }
          
          .apexcharts-xcrosshairs.apexcharts-active,
          .apexcharts-ycrosshairs.apexcharts-active {
               opacity: 1;
               transition: 0.15s ease all;
          }
          
          .apexcharts-ycrosshairs-hidden {
               opacity: 0;
          }
          
          .apexcharts-selection-rect {
               cursor: move;
          }
          
          .svg_select_boundingRect,
          .svg_select_points_rot {
               pointer-events: none;
               opacity: 0;
               visibility: hidden;
          }
          
          .apexcharts-selection-rect+ g .svg_select_boundingRect,
          .apexcharts-selection-rect+ g .svg_select_points_rot {
               opacity: 0;
               visibility: hidden;
          }
          
          .apexcharts-selection-rect+ g .svg_select_points_l,
          .apexcharts-selection-rect+ g .svg_select_points_r {
               cursor: ew-resize;
               opacity: 1;
               visibility: visible;
          }
          
          .svg_select_points {
               fill: #efefef;
               stroke: #333;
               rx: 2;
          }
          
          .apexcharts-svg.apexcharts-zoomable.hovering-zoom {
               cursor: crosshair
          }
          
          .apexcharts-svg.apexcharts-zoomable.hovering-pan {
               cursor: move
          }
          
          .apexcharts-zoom-icon,
          .apexcharts-zoomin-icon,
          .apexcharts-zoomout-icon,
          .apexcharts-reset-icon,
          .apexcharts-pan-icon,
          .apexcharts-selection-icon,
          .apexcharts-menu-icon,
          .apexcharts-toolbar-custom-icon {
               cursor: pointer;
               width: 20px;
               height: 20px;
               line-height: 24px;
               color: #6E8192;
               text-align: center;
          }
          
          .apexcharts-zoom-icon svg,
          .apexcharts-zoomin-icon svg,
          .apexcharts-zoomout-icon svg,
          .apexcharts-reset-icon svg,
          .apexcharts-menu-icon svg {
               fill: #6E8192;
          }
          
          .apexcharts-selection-icon svg {
               fill: #444;
               transform: scale(0.76)
          }
          
          .apexcharts-theme-dark .apexcharts-zoom-icon svg,
          .apexcharts-theme-dark .apexcharts-zoomin-icon svg,
          .apexcharts-theme-dark .apexcharts-zoomout-icon svg,
          .apexcharts-theme-dark .apexcharts-reset-icon svg,
          .apexcharts-theme-dark .apexcharts-pan-icon svg,
          .apexcharts-theme-dark .apexcharts-selection-icon svg,
          .apexcharts-theme-dark .apexcharts-menu-icon svg,
          .apexcharts-theme-dark .apexcharts-toolbar-custom-icon svg {
               fill: #f3f4f5;
          }
          
          .apexcharts-canvas .apexcharts-zoom-icon.apexcharts-selected svg,
          .apexcharts-canvas .apexcharts-selection-icon.apexcharts-selected svg,
          .apexcharts-canvas .apexcharts-reset-zoom-icon.apexcharts-selected svg {
               fill: #008FFB;
          }
          
          .apexcharts-theme-light .apexcharts-selection-icon:not(.apexcharts-selected):hover svg,
          .apexcharts-theme-light .apexcharts-zoom-icon:not(.apexcharts-selected):hover svg,
          .apexcharts-theme-light .apexcharts-zoomin-icon:hover svg,
          .apexcharts-theme-light .apexcharts-zoomout-icon:hover svg,
          .apexcharts-theme-light .apexcharts-reset-icon:hover svg,
          .apexcharts-theme-light .apexcharts-menu-icon:hover svg {
               fill: #333;
          }
          
          .apexcharts-selection-icon,
          .apexcharts-menu-icon {
               position: relative;
          }
          
          .apexcharts-reset-icon {
               margin-left: 5px;
          }
          
          .apexcharts-zoom-icon,
          .apexcharts-reset-icon,
          .apexcharts-menu-icon {
               transform: scale(0.85);
          }
          
          .apexcharts-zoomin-icon,
          .apexcharts-zoomout-icon {
               transform: scale(0.7)
          }
          
          .apexcharts-zoomout-icon {
               margin-right: 3px;
          }
          
          .apexcharts-pan-icon {
               transform: scale(0.62);
               position: relative;
               left: 1px;
               top: 0px;
          }
          
          .apexcharts-pan-icon svg {
               fill: #fff;
               stroke: #6E8192;
               stroke-width: 2;
          }
          
          .apexcharts-pan-icon.apexcharts-selected svg {
               stroke: #008FFB;
          }
          
          .apexcharts-pan-icon:not(.apexcharts-selected):hover svg {
               stroke: #333;
          }
          
          .apexcharts-toolbar {
               position: absolute;
               z-index: 11;
               max-width: 176px;
               text-align: right;
               border-radius: 3px;
               padding: 0px 6px 2px 6px;
               display: flex;
               justify-content: space-between;
               align-items: center;
          }
          
          .apexcharts-menu {
               background: #fff;
               position: absolute;
               top: 100%;
               border: 1px solid #ddd;
               border-radius: 3px;
               padding: 3px;
               right: 10px;
               opacity: 0;
               min-width: 110px;
               transition: 0.15s ease all;
               pointer-events: none;
          }
          
          .apexcharts-menu.apexcharts-menu-open {
               opacity: 1;
               pointer-events: all;
               transition: 0.15s ease all;
          }
          
          .apexcharts-menu-item {
               padding: 6px 7px;
               font-size: 12px;
               cursor: pointer;
          }
          
          .apexcharts-theme-light .apexcharts-menu-item:hover {
               background: #eee;
          }
          
          .apexcharts-theme-dark .apexcharts-menu {
               background: rgba(0, 0, 0, 0.7);
               color: #fff;
          }
          
          @media screen and (min-width: 768px) {
               .apexcharts-canvas:hover .apexcharts-toolbar {
                    opacity: 1;
               }
          }
          
          .apexcharts-datalabel.apexcharts-element-hidden {
               opacity: 0;
          }
          
          .apexcharts-pie-label,
          .apexcharts-datalabels,
          .apexcharts-datalabel,
          .apexcharts-datalabel-label,
          .apexcharts-datalabel-value {
               cursor: default;
               pointer-events: none;
          }
          
          .apexcharts-pie-label-delay {
               opacity: 0;
               animation-name: opaque;
               animation-duration: 0.3s;
               animation-fill-mode: forwards;
               animation-timing-function: ease;
          }
          
          .apexcharts-canvas .apexcharts-element-hidden {
               opacity: 0;
          }
          
          .apexcharts-hide .apexcharts-series-points {
               opacity: 0;
          }
          
          .apexcharts-gridline,
          .apexcharts-annotation-rect,
          .apexcharts-tooltip .apexcharts-marker,
          .apexcharts-area-series .apexcharts-area,
          .apexcharts-line,
          .apexcharts-zoom-rect,
          .apexcharts-toolbar svg,
          .apexcharts-area-series .apexcharts-series-markers .apexcharts-marker.no-pointer-events,
          .apexcharts-line-series .apexcharts-series-markers .apexcharts-marker.no-pointer-events,
          .apexcharts-radar-series path,
          .apexcharts-radar-series polygon {
               pointer-events: none;
          }
          /* markers */
          
          .apexcharts-marker {
               transition: 0.15s ease all;
          }
          
          @keyframes opaque {
               0% {
                    opacity: 0;
               }
               100% {
                    opacity: 1;
               }
          }
          /* Resize generated styles */
          
          @keyframes resizeanim {
               from {
                    opacity: 0;
               }
               to {
                    opacity: 0;
               }
          }
          
          .resize-triggers {
               animation: 1ms resizeanim;
               visibility: hidden;
               opacity: 0;
          }
          
          .resize-triggers,
          .resize-triggers>div,
          .contract-trigger:before {
               content: " ";
               display: block;
               position: absolute;
               top: 0;
               left: 0;
               height: 100%;
               width: 100%;
               overflow: hidden;
          }
          
          .resize-triggers>div {
               background: #eee;
               overflow: auto;
          }
          
          .contract-trigger:before {
               width: 200%;
               height: 200%;
          }
     </style>
     <style>
          .la-ball-8bits[_ngcontent-pjk-c38],
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-8bits.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38] {
               height: 12px;
               width: 12px
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-8bits 1s ease 0s infinite;
               animation: ball-8bits 1s ease 0s infinite;
               border-radius: 0;
               height: 4px;
               left: 50%;
               opacity: 0;
               position: absolute;
               top: 50%;
               transform: translate(100%, 100%);
               width: 4px
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -.9375s;
               animation-delay: -.9375s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.875s;
               animation-delay: -.875s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.8125s;
               animation-delay: -.8125s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.75s;
               animation-delay: -.75s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -.6875s;
               animation-delay: -.6875s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -.625s;
               animation-delay: -.625s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -.5625s;
               animation-delay: -.5625s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: -.5s;
               animation-delay: -.5s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(9) {
               -webkit-animation-delay: -.4375s;
               animation-delay: -.4375s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(10) {
               -webkit-animation-delay: -.375s;
               animation-delay: -.375s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(11) {
               -webkit-animation-delay: -.3125s;
               animation-delay: -.3125s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(12) {
               -webkit-animation-delay: -.25s;
               animation-delay: -.25s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(13) {
               -webkit-animation-delay: -.1875s;
               animation-delay: -.1875s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(14) {
               -webkit-animation-delay: -.125s;
               animation-delay: -.125s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(15) {
               -webkit-animation-delay: -.0625s;
               animation-delay: -.0625s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(16) {
               -webkit-animation-delay: 0s;
               animation-delay: 0s
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               left: 0;
               top: -100%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               left: 33.3333333333%;
               top: -100%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               left: 66.6666666667%;
               top: -66.6666666667%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               left: 100%;
               top: -33.3333333333%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               left: 100%;
               top: 0
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               left: 100%;
               top: 33.3333333333%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               left: 66.6666666667%;
               top: 66.6666666667%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               left: 33.3333333333%;
               top: 100%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(9) {
               left: 0;
               top: 100%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(10) {
               left: -33.3333333333%;
               top: 100%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(11) {
               left: -66.6666666667%;
               top: 66.6666666667%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(12) {
               left: -100%;
               top: 33.3333333333%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(13) {
               left: -100%;
               top: 0
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(14) {
               left: -100%;
               top: -33.3333333333%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(15) {
               left: -66.6666666667%;
               top: -66.6666666667%
          }
          
          .la-ball-8bits[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(16) {
               left: -33.3333333333%;
               top: -100%
          }
          
          .la-ball-8bits.la-sm[_ngcontent-pjk-c38] {
               height: 6px;
               width: 6px
          }
          
          .la-ball-8bits.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 2px;
               width: 2px
          }
          
          .la-ball-8bits.la-2x[_ngcontent-pjk-c38] {
               height: 24px;
               width: 24px
          }
          
          .la-ball-8bits.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 8px;
               width: 8px
          }
          
          .la-ball-8bits.la-3x[_ngcontent-pjk-c38] {
               height: 36px;
               width: 36px
          }
          
          .la-ball-8bits.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 12px;
               width: 12px
          }
          
          @-webkit-keyframes ball-8bits {
               0% {
                    opacity: 1
               }
               50% {
                    opacity: 1
               }
               51% {
                    opacity: 0
               }
          }
          
          @keyframes ball-8bits {
               0% {
                    opacity: 1
               }
               50% {
                    opacity: 1
               }
               51% {
                    opacity: 0
               }
          }
          
          .la-ball-atom[_ngcontent-pjk-c38],
          .la-ball-atom[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-atom[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-atom.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-atom[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-atom[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-atom[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation: ball-atom-shrink 4.5s linear infinite;
               animation: ball-atom-shrink 4.5s linear infinite;
               background: #aaa;
               border-radius: 100%;
               height: 60%;
               left: 50%;
               position: absolute;
               top: 50%;
               transform: translate(-50%, -50%);
               width: 60%;
               z-index: 1
          }
          
          .la-ball-atom[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(:first-child) {
               -webkit-animation: ball-atom-zindex 1.5s steps(2) 0s infinite;
               animation: ball-atom-zindex 1.5s steps(2) 0s infinite;
               background: none;
               height: 100%;
               left: 0;
               position: absolute;
               width: 100%;
               z-index: 0
          }
          
          .la-ball-atom[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(:first-child):before {
               -webkit-animation: ball-atom-position 1.5s ease 0s infinite, ball-atom-size 1.5s ease 0s infinite;
               animation: ball-atom-position 1.5s ease 0s infinite, ball-atom-size 1.5s ease 0s infinite;
               background: currentColor;
               border-radius: 50%;
               content: "";
               height: 10px;
               left: 0;
               margin-left: -5px;
               margin-top: -5px;
               opacity: .75;
               position: absolute;
               top: 0;
               width: 10px
          }
          
          .la-ball-atom[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: .75s;
               animation-delay: .75s
          }
          
          .la-ball-atom[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2):before {
               -webkit-animation-delay: 0s, -1.125s;
               animation-delay: 0s, -1.125s
          }
          
          .la-ball-atom[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.25s;
               animation-delay: -.25s;
               transform: rotate(120deg)
          }
          
          .la-ball-atom[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3):before {
               -webkit-animation-delay: -1s, -.75s;
               animation-delay: -1s, -.75s
          }
          
          .la-ball-atom[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: .25s;
               animation-delay: .25s;
               transform: rotate(240deg)
          }
          
          .la-ball-atom[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4):before {
               -webkit-animation-delay: -.5s, -.125s;
               animation-delay: -.5s, -.125s
          }
          
          .la-ball-atom.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-atom.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(:first-child):before {
               height: 4px;
               margin-left: -2px;
               margin-top: -2px;
               width: 4px
          }
          
          .la-ball-atom.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-atom.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(:first-child):before {
               height: 20px;
               margin-left: -10px;
               margin-top: -10px;
               width: 20px
          }
          
          .la-ball-atom.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-atom.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(:first-child):before {
               height: 30px;
               margin-left: -15px;
               margin-top: -15px;
               width: 30px
          }
          
          @-webkit-keyframes ball-atom-position {
               50% {
                    left: 100%;
                    top: 100%
               }
          }
          
          @keyframes ball-atom-position {
               50% {
                    left: 100%;
                    top: 100%
               }
          }
          
          @-webkit-keyframes ball-atom-size {
               50% {
                    transform: scale(.5)
               }
          }
          
          @keyframes ball-atom-size {
               50% {
                    transform: scale(.5)
               }
          }
          
          @-webkit-keyframes ball-atom-zindex {
               50% {
                    z-index: 10
               }
          }
          
          @keyframes ball-atom-zindex {
               50% {
                    z-index: 10
               }
          }
          
          @-webkit-keyframes ball-atom-shrink {
               50% {
                    transform: translate(-50%, -50%) scale(.8)
               }
          }
          
          @keyframes ball-atom-shrink {
               50% {
                    transform: translate(-50%, -50%) scale(.8)
               }
          }
          
          .la-ball-beat[_ngcontent-pjk-c38],
          .la-ball-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-beat[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-beat.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-beat[_ngcontent-pjk-c38] {
               height: 18px;
               width: 54px
          }
          
          .la-ball-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-beat .7s linear -.15s infinite;
               animation: ball-beat .7s linear -.15s infinite;
               border-radius: 100%;
               height: 10px;
               margin: 4px;
               width: 10px
          }
          
          .la-ball-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2n-1) {
               -webkit-animation-delay: -.5s;
               animation-delay: -.5s
          }
          
          .la-ball-beat.la-sm[_ngcontent-pjk-c38] {
               height: 8px;
               width: 26px
          }
          
          .la-ball-beat.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin: 2px;
               width: 4px
          }
          
          .la-ball-beat.la-2x[_ngcontent-pjk-c38] {
               height: 36px;
               width: 108px
          }
          
          .la-ball-beat.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               margin: 8px;
               width: 20px
          }
          
          .la-ball-beat.la-3x[_ngcontent-pjk-c38] {
               height: 54px;
               width: 162px
          }
          
          .la-ball-beat.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               margin: 12px;
               width: 30px
          }
          
          @-webkit-keyframes ball-beat {
               50% {
                    opacity: .2;
                    transform: scale(.75)
               }
               to {
                    opacity: 1;
                    transform: scale(1)
               }
          }
          
          @keyframes ball-beat {
               50% {
                    opacity: .2;
                    transform: scale(.75)
               }
               to {
                    opacity: 1;
                    transform: scale(1)
               }
          }
          
          .la-ball-circus[_ngcontent-pjk-c38],
          .la-ball-circus[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-circus[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-circus.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-circus[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-circus[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-circus[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-circus-position 2.5s cubic-bezier(.25, 0, .75, 1) infinite, ball-circus-size 2.5s cubic-bezier(.25, 0, .75, 1) infinite;
               animation: ball-circus-position 2.5s cubic-bezier(.25, 0, .75, 1) infinite, ball-circus-size 2.5s cubic-bezier(.25, 0, .75, 1) infinite;
               border-radius: 100%;
               display: block;
               height: 16px;
               height: 100%;
               left: -100%;
               opacity: .5;
               position: absolute;
               top: 0;
               width: 16px;
               width: 100%
          }
          
          .la-ball-circus[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: 0s, -.5s;
               animation-delay: 0s, -.5s
          }
          
          .la-ball-circus[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.5s, -1s;
               animation-delay: -.5s, -1s
          }
          
          .la-ball-circus[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -1s, -1.5s;
               animation-delay: -1s, -1.5s
          }
          
          .la-ball-circus[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -1.5s, -2s;
               animation-delay: -1.5s, -2s
          }
          
          .la-ball-circus[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -2s, -2.5s;
               animation-delay: -2s, -2.5s
          }
          
          .la-ball-circus.la-sm[_ngcontent-pjk-c38],
          .la-ball-circus.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 8px;
               width: 8px
          }
          
          .la-ball-circus.la-2x[_ngcontent-pjk-c38],
          .la-ball-circus.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-circus.la-3x[_ngcontent-pjk-c38],
          .la-ball-circus.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 48px;
               width: 48px
          }
          
          @-webkit-keyframes ball-circus-position {
               50% {
                    left: 100%
               }
          }
          
          @keyframes ball-circus-position {
               50% {
                    left: 100%
               }
          }
          
          @-webkit-keyframes ball-circus-size {
               50% {
                    transform: scale(.3)
               }
          }
          
          @keyframes ball-circus-size {
               50% {
                    transform: scale(.3)
               }
          }
          
          .la-ball-climbing-dot[_ngcontent-pjk-c38],
          .la-ball-climbing-dot[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-climbing-dot[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-climbing-dot.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-climbing-dot[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-climbing-dot[_ngcontent-pjk-c38] {
               height: 32px;
               width: 42px
          }
          
          .la-ball-climbing-dot[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation: ball-climbing-dot-jump .6s ease-in-out infinite;
               animation: ball-climbing-dot-jump .6s ease-in-out infinite;
               border-radius: 100%;
               bottom: 32%;
               height: 14px;
               left: 18%;
               position: absolute;
               transform-origin: center bottom;
               width: 14px
          }
          
          .la-ball-climbing-dot[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(:first-child) {
               -webkit-animation: ball-climbing-dot-steps 1.8s linear infinite;
               animation: ball-climbing-dot-steps 1.8s linear infinite;
               border-radius: 0;
               height: 2px;
               position: absolute;
               right: 0;
               top: 0;
               transform: translate(60%);
               width: 14px
          }
          
          .la-ball-climbing-dot[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(:first-child):nth-child(2) {
               -webkit-animation-delay: 0ms;
               animation-delay: 0ms
          }
          
          .la-ball-climbing-dot[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(:first-child):nth-child(3) {
               -webkit-animation-delay: -.6s;
               animation-delay: -.6s
          }
          
          .la-ball-climbing-dot[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(:first-child):nth-child(4) {
               -webkit-animation-delay: -1.2s;
               animation-delay: -1.2s
          }
          
          .la-ball-climbing-dot.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 20px
          }
          
          .la-ball-climbing-dot.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               height: 6px;
               width: 6px
          }
          
          .la-ball-climbing-dot.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(:first-child) {
               height: 1px;
               width: 6px
          }
          
          .la-ball-climbing-dot.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 84px
          }
          
          .la-ball-climbing-dot.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               height: 28px;
               width: 28px
          }
          
          .la-ball-climbing-dot.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(:first-child) {
               height: 4px;
               width: 28px
          }
          
          .la-ball-climbing-dot.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 126px
          }
          
          .la-ball-climbing-dot.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               height: 42px;
               width: 42px
          }
          
          .la-ball-climbing-dot.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(:first-child) {
               height: 6px;
               width: 42px
          }
          
          @-webkit-keyframes ball-climbing-dot-jump {
               0% {
                    transform: scaleY(.7)
               }
               20% {
                    transform: scale(.7, 1.2)
               }
               40% {
                    transform: scale(1)
               }
               50% {
                    bottom: 125%
               }
               46% {
                    transform: scale(1)
               }
               80% {
                    transform: scale(.7, 1.2)
               }
               90% {
                    transform: scale(.7, 1.2)
               }
               to {
                    transform: scaleY(.7)
               }
          }
          
          @keyframes ball-climbing-dot-jump {
               0% {
                    transform: scaleY(.7)
               }
               20% {
                    transform: scale(.7, 1.2)
               }
               40% {
                    transform: scale(1)
               }
               50% {
                    bottom: 125%
               }
               46% {
                    transform: scale(1)
               }
               80% {
                    transform: scale(.7, 1.2)
               }
               90% {
                    transform: scale(.7, 1.2)
               }
               to {
                    transform: scaleY(.7)
               }
          }
          
          @-webkit-keyframes ball-climbing-dot-steps {
               0% {
                    opacity: 0;
                    right: 0;
                    top: 0
               }
               50% {
                    opacity: 1
               }
               to {
                    opacity: 0;
                    right: 100%;
                    top: 100%
               }
          }
          
          @keyframes ball-climbing-dot-steps {
               0% {
                    opacity: 0;
                    right: 0;
                    top: 0
               }
               50% {
                    opacity: 1
               }
               to {
                    opacity: 0;
                    right: 100%;
                    top: 100%
               }
          }
          
          .la-ball-clip-rotate-multiple[_ngcontent-pjk-c38],
          .la-ball-clip-rotate-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-clip-rotate-multiple[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-clip-rotate-multiple.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-clip-rotate-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-clip-rotate-multiple[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-clip-rotate-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-clip-rotate-multiple-rotate 1s ease-in-out infinite;
               animation: ball-clip-rotate-multiple-rotate 1s ease-in-out infinite;
               background: transparent;
               border-radius: 100%;
               border-style: solid;
               border-width: 2px;
               left: 50%;
               position: absolute;
               top: 50%
          }
          
          .la-ball-clip-rotate-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               border-left-color: transparent;
               border-right-color: transparent;
               height: 32px;
               position: absolute;
               width: 32px
          }
          
          .la-ball-clip-rotate-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               -webkit-animation-direction: reverse;
               -webkit-animation-duration: .5s;
               animation-direction: reverse;
               animation-duration: .5s;
               border-bottom-color: transparent;
               border-top-color: transparent;
               height: 16px;
               width: 16px
          }
          
          .la-ball-clip-rotate-multiple.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-clip-rotate-multiple.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 1px
          }
          
          .la-ball-clip-rotate-multiple.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               height: 16px;
               width: 16px
          }
          
          .la-ball-clip-rotate-multiple.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               height: 8px;
               width: 8px
          }
          
          .la-ball-clip-rotate-multiple.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-clip-rotate-multiple.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 4px
          }
          
          .la-ball-clip-rotate-multiple.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               height: 64px;
               width: 64px
          }
          
          .la-ball-clip-rotate-multiple.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               height: 32px;
               width: 32px
          }
          
          .la-ball-clip-rotate-multiple.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-clip-rotate-multiple.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 6px
          }
          
          .la-ball-clip-rotate-multiple.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               height: 96px;
               width: 96px
          }
          
          .la-ball-clip-rotate-multiple.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               height: 48px;
               width: 48px
          }
          
          @-webkit-keyframes ball-clip-rotate-multiple-rotate {
               0% {
                    transform: translate(-50%, -50%) rotate(0deg)
               }
               50% {
                    transform: translate(-50%, -50%) rotate(180deg)
               }
               to {
                    transform: translate(-50%, -50%) rotate(1turn)
               }
          }
          
          @keyframes ball-clip-rotate-multiple-rotate {
               0% {
                    transform: translate(-50%, -50%) rotate(0deg)
               }
               50% {
                    transform: translate(-50%, -50%) rotate(180deg)
               }
               to {
                    transform: translate(-50%, -50%) rotate(1turn)
               }
          }
          
          .la-ball-clip-rotate-pulse[_ngcontent-pjk-c38],
          .la-ball-clip-rotate-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-clip-rotate-pulse[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-clip-rotate-pulse.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-clip-rotate-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-clip-rotate-pulse[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-clip-rotate-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-radius: 100%;
               left: 50%;
               position: absolute;
               top: 50%
          }
          
          .la-ball-clip-rotate-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation: ball-clip-rotate-pulse-rotate 1s cubic-bezier(.09, .57, .49, .9) infinite;
               animation: ball-clip-rotate-pulse-rotate 1s cubic-bezier(.09, .57, .49, .9) infinite;
               background: transparent;
               border-bottom-style: solid;
               border-bottom-width: 2px;
               border-left: 2px solid transparent;
               border-right: 2px solid transparent;
               border-top-style: solid;
               border-top-width: 2px;
               height: 32px;
               position: absolute;
               width: 32px
          }
          
          .la-ball-clip-rotate-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               -webkit-animation: ball-clip-rotate-pulse-scale 1s cubic-bezier(.09, .57, .49, .9) infinite;
               animation: ball-clip-rotate-pulse-scale 1s cubic-bezier(.09, .57, .49, .9) infinite;
               height: 16px;
               width: 16px
          }
          
          .la-ball-clip-rotate-pulse.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-clip-rotate-pulse.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               border-width: 1px;
               height: 16px;
               width: 16px
          }
          
          .la-ball-clip-rotate-pulse.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               height: 8px;
               width: 8px
          }
          
          .la-ball-clip-rotate-pulse.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-clip-rotate-pulse.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               border-width: 4px;
               height: 64px;
               width: 64px
          }
          
          .la-ball-clip-rotate-pulse.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               height: 32px;
               width: 32px
          }
          
          .la-ball-clip-rotate-pulse.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-clip-rotate-pulse.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               border-width: 6px;
               height: 96px;
               width: 96px
          }
          
          .la-ball-clip-rotate-pulse.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               height: 48px;
               width: 48px
          }
          
          @-webkit-keyframes ball-clip-rotate-pulse-rotate {
               0% {
                    transform: translate(-50%, -50%) rotate(0deg)
               }
               50% {
                    transform: translate(-50%, -50%) rotate(180deg)
               }
               to {
                    transform: translate(-50%, -50%) rotate(1turn)
               }
          }
          
          @keyframes ball-clip-rotate-pulse-rotate {
               0% {
                    transform: translate(-50%, -50%) rotate(0deg)
               }
               50% {
                    transform: translate(-50%, -50%) rotate(180deg)
               }
               to {
                    transform: translate(-50%, -50%) rotate(1turn)
               }
          }
          
          @-webkit-keyframes ball-clip-rotate-pulse-scale {
               0%,
               to {
                    opacity: 1;
                    transform: translate(-50%, -50%) scale(1)
               }
               30% {
                    opacity: .3;
                    transform: translate(-50%, -50%) scale(.15)
               }
          }
          
          @keyframes ball-clip-rotate-pulse-scale {
               0%,
               to {
                    opacity: 1;
                    transform: translate(-50%, -50%) scale(1)
               }
               30% {
                    opacity: .3;
                    transform: translate(-50%, -50%) scale(.15)
               }
          }
          
          .la-ball-clip-rotate[_ngcontent-pjk-c38],
          .la-ball-clip-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-clip-rotate[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-clip-rotate.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-clip-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-clip-rotate[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-clip-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-clip-rotate .75s linear infinite;
               animation: ball-clip-rotate .75s linear infinite;
               background: transparent;
               border-bottom-color: transparent;
               border-radius: 100%;
               border-width: 2px;
               height: 32px;
               width: 32px
          }
          
          .la-ball-clip-rotate.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-clip-rotate.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 1px;
               height: 16px;
               width: 16px
          }
          
          .la-ball-clip-rotate.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-clip-rotate.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 4px;
               height: 64px;
               width: 64px
          }
          
          .la-ball-clip-rotate.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-clip-rotate.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 6px;
               height: 96px;
               width: 96px
          }
          
          @-webkit-keyframes ball-clip-rotate {
               0% {
                    transform: rotate(0deg)
               }
               50% {
                    transform: rotate(180deg)
               }
               to {
                    transform: rotate(1turn)
               }
          }
          
          @keyframes ball-clip-rotate {
               0% {
                    transform: rotate(0deg)
               }
               50% {
                    transform: rotate(180deg)
               }
               to {
                    transform: rotate(1turn)
               }
          }
          
          .la-ball-elastic-dots[_ngcontent-pjk-c38],
          .la-ball-elastic-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-elastic-dots[_ngcontent-pjk-c38] {
               color: #fff;
               display: block
          }
          
          .la-ball-elastic-dots.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-elastic-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               float: none
          }
          
          .la-ball-elastic-dots[_ngcontent-pjk-c38] {
               font-size: 0;
               height: 10px;
               text-align: center;
               width: 120px
          }
          
          .la-ball-elastic-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-elastic-dots-anim 1s infinite;
               animation: ball-elastic-dots-anim 1s infinite;
               border-radius: 100%;
               display: inline-block;
               height: 10px;
               white-space: nowrap;
               width: 10px
          }
          
          .la-ball-elastic-dots.la-sm[_ngcontent-pjk-c38] {
               height: 4px;
               width: 60px
          }
          
          .la-ball-elastic-dots.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               width: 4px
          }
          
          .la-ball-elastic-dots.la-2x[_ngcontent-pjk-c38] {
               height: 20px;
               width: 240px
          }
          
          .la-ball-elastic-dots.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               width: 20px
          }
          
          .la-ball-elastic-dots.la-3x[_ngcontent-pjk-c38] {
               height: 30px;
               width: 360px
          }
          
          .la-ball-elastic-dots.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               width: 30px
          }
          
          @-webkit-keyframes ball-elastic-dots-anim {
               0%,
               to {
                    margin: 0;
                    transform: scale(1)
               }
               50% {
                    margin: 0 5%;
                    transform: scale(.65)
               }
          }
          
          @keyframes ball-elastic-dots-anim {
               0%,
               to {
                    margin: 0;
                    transform: scale(1)
               }
               50% {
                    margin: 0 5%;
                    transform: scale(.65)
               }
          }
          
          .la-ball-fall[_ngcontent-pjk-c38],
          .la-ball-fall[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-fall[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-fall.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-fall[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-fall[_ngcontent-pjk-c38] {
               height: 18px;
               width: 54px
          }
          
          .la-ball-fall[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-fall 1s ease-in-out infinite;
               animation: ball-fall 1s ease-in-out infinite;
               border-radius: 100%;
               height: 10px;
               margin: 4px;
               opacity: 0;
               width: 10px
          }
          
          .la-ball-fall[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -.2s;
               animation-delay: -.2s
          }
          
          .la-ball-fall[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.1s;
               animation-delay: -.1s
          }
          
          .la-ball-fall[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: 0ms;
               animation-delay: 0ms
          }
          
          .la-ball-fall.la-sm[_ngcontent-pjk-c38] {
               height: 8px;
               width: 26px
          }
          
          .la-ball-fall.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin: 2px;
               width: 4px
          }
          
          .la-ball-fall.la-2x[_ngcontent-pjk-c38] {
               height: 36px;
               width: 108px
          }
          
          .la-ball-fall.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               margin: 8px;
               width: 20px
          }
          
          .la-ball-fall.la-3x[_ngcontent-pjk-c38] {
               height: 54px;
               width: 162px
          }
          
          .la-ball-fall.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               margin: 12px;
               width: 30px
          }
          
          @-webkit-keyframes ball-fall {
               0% {
                    opacity: 0;
                    transform: translateY(-145%)
               }
               10% {
                    opacity: .5
               }
               20% {
                    opacity: 1;
                    transform: translateY(0)
               }
               80% {
                    opacity: 1;
                    transform: translateY(0)
               }
               90% {
                    opacity: .5
               }
               to {
                    opacity: 0;
                    transform: translateY(145%)
               }
          }
          
          @keyframes ball-fall {
               0% {
                    opacity: 0;
                    transform: translateY(-145%)
               }
               10% {
                    opacity: .5
               }
               20% {
                    opacity: 1;
                    transform: translateY(0)
               }
               80% {
                    opacity: 1;
                    transform: translateY(0)
               }
               90% {
                    opacity: .5
               }
               to {
                    opacity: 0;
                    transform: translateY(145%)
               }
          }
          
          .la-ball-fussion[_ngcontent-pjk-c38],
          .la-ball-fussion[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-fussion[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-fussion.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-fussion[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-fussion[_ngcontent-pjk-c38] {
               height: 8px;
               width: 8px
          }
          
          .la-ball-fussion[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-fussion-ball1 1s ease 0s infinite;
               animation: ball-fussion-ball1 1s ease 0s infinite;
               border-radius: 100%;
               height: 12px;
               position: absolute;
               transform: translate(-50%, -50%);
               width: 12px
          }
          
          .la-ball-fussion[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               left: 50%;
               top: 0;
               z-index: 1
          }
          
          .la-ball-fussion[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-name: ball-fussion-ball2;
               animation-name: ball-fussion-ball2;
               left: 100%;
               top: 50%;
               z-index: 2
          }
          
          .la-ball-fussion[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-name: ball-fussion-ball3;
               animation-name: ball-fussion-ball3;
               left: 50%;
               top: 100%;
               z-index: 1
          }
          
          .la-ball-fussion[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-name: ball-fussion-ball4;
               animation-name: ball-fussion-ball4;
               left: 0;
               top: 50%;
               z-index: 2
          }
          
          .la-ball-fussion.la-sm[_ngcontent-pjk-c38] {
               height: 4px;
               width: 4px
          }
          
          .la-ball-fussion.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 6px;
               width: 6px
          }
          
          .la-ball-fussion.la-2x[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-fussion.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38],
          .la-ball-fussion.la-3x[_ngcontent-pjk-c38] {
               height: 24px;
               width: 24px
          }
          
          .la-ball-fussion.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 36px;
               width: 36px
          }
          
          @-webkit-keyframes ball-fussion-ball1 {
               0% {
                    opacity: .35
               }
               50% {
                    left: 200%;
                    opacity: 1;
                    top: -100%
               }
               to {
                    left: 100%;
                    opacity: .35;
                    top: 50%;
                    z-index: 2
               }
          }
          
          @keyframes ball-fussion-ball1 {
               0% {
                    opacity: .35
               }
               50% {
                    left: 200%;
                    opacity: 1;
                    top: -100%
               }
               to {
                    left: 100%;
                    opacity: .35;
                    top: 50%;
                    z-index: 2
               }
          }
          
          @-webkit-keyframes ball-fussion-ball2 {
               0% {
                    opacity: .35
               }
               50% {
                    left: 200%;
                    opacity: 1;
                    top: 200%
               }
               to {
                    left: 50%;
                    opacity: .35;
                    top: 100%;
                    z-index: 1
               }
          }
          
          @keyframes ball-fussion-ball2 {
               0% {
                    opacity: .35
               }
               50% {
                    left: 200%;
                    opacity: 1;
                    top: 200%
               }
               to {
                    left: 50%;
                    opacity: .35;
                    top: 100%;
                    z-index: 1
               }
          }
          
          @-webkit-keyframes ball-fussion-ball3 {
               0% {
                    opacity: .35
               }
               50% {
                    left: -100%;
                    opacity: 1;
                    top: 200%
               }
               to {
                    left: 0;
                    opacity: .35;
                    top: 50%;
                    z-index: 2
               }
          }
          
          @keyframes ball-fussion-ball3 {
               0% {
                    opacity: .35
               }
               50% {
                    left: -100%;
                    opacity: 1;
                    top: 200%
               }
               to {
                    left: 0;
                    opacity: .35;
                    top: 50%;
                    z-index: 2
               }
          }
          
          @-webkit-keyframes ball-fussion-ball4 {
               0% {
                    opacity: .35
               }
               50% {
                    left: -100%;
                    opacity: 1;
                    top: -100%
               }
               to {
                    left: 50%;
                    opacity: .35;
                    top: 0;
                    z-index: 1
               }
          }
          
          @keyframes ball-fussion-ball4 {
               0% {
                    opacity: .35
               }
               50% {
                    left: -100%;
                    opacity: 1;
                    top: -100%
               }
               to {
                    left: 50%;
                    opacity: .35;
                    top: 0;
                    z-index: 1
               }
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38],
          .la-ball-grid-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-grid-beat.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38] {
               height: 36px;
               width: 36px
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation-iteration-count: infinite;
               -webkit-animation-name: ball-grid-beat;
               animation-iteration-count: infinite;
               animation-name: ball-grid-beat;
               border-radius: 100%;
               height: 8px;
               margin: 2px;
               width: 8px
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: .03s;
               -webkit-animation-duration: .65s;
               animation-delay: .03s;
               animation-duration: .65s
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: .09s;
               -webkit-animation-duration: 1.02s;
               animation-delay: .09s;
               animation-duration: 1.02s
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.69s;
               -webkit-animation-duration: 1.06s;
               animation-delay: -.69s;
               animation-duration: 1.06s
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.41s;
               -webkit-animation-duration: 1.5s;
               animation-delay: -.41s;
               animation-duration: 1.5s
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: .04s;
               -webkit-animation-duration: 1.6s;
               animation-delay: .04s;
               animation-duration: 1.6s
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: .07s;
               -webkit-animation-duration: .84s;
               animation-delay: .07s;
               animation-duration: .84s
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -.66s;
               -webkit-animation-duration: .68s;
               animation-delay: -.66s;
               animation-duration: .68s
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: -.76s;
               -webkit-animation-duration: .93s;
               animation-delay: -.76s;
               animation-duration: .93s
          }
          
          .la-ball-grid-beat[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(9) {
               -webkit-animation-delay: -.76s;
               -webkit-animation-duration: 1.24s;
               animation-delay: -.76s;
               animation-duration: 1.24s
          }
          
          .la-ball-grid-beat.la-sm[_ngcontent-pjk-c38] {
               height: 18px;
               width: 18px
          }
          
          .la-ball-grid-beat.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin: 1px;
               width: 4px
          }
          
          .la-ball-grid-beat.la-2x[_ngcontent-pjk-c38] {
               height: 72px;
               width: 72px
          }
          
          .la-ball-grid-beat.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               margin: 4px;
               width: 16px
          }
          
          .la-ball-grid-beat.la-3x[_ngcontent-pjk-c38] {
               height: 108px;
               width: 108px
          }
          
          .la-ball-grid-beat.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 24px;
               margin: 6px;
               width: 24px
          }
          
          @-webkit-keyframes ball-grid-beat {
               0% {
                    opacity: 1
               }
               50% {
                    opacity: .35
               }
               to {
                    opacity: 1
               }
          }
          
          @keyframes ball-grid-beat {
               0% {
                    opacity: 1
               }
               50% {
                    opacity: .35
               }
               to {
                    opacity: 1
               }
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38],
          .la-ball-grid-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-grid-pulse.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38] {
               height: 36px;
               width: 36px
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation-iteration-count: infinite;
               -webkit-animation-name: ball-grid-pulse;
               animation-iteration-count: infinite;
               animation-name: ball-grid-pulse;
               border-radius: 100%;
               height: 8px;
               margin: 2px;
               width: 8px
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: .03s;
               -webkit-animation-duration: .65s;
               animation-delay: .03s;
               animation-duration: .65s
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: .09s;
               -webkit-animation-duration: 1.02s;
               animation-delay: .09s;
               animation-duration: 1.02s
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.69s;
               -webkit-animation-duration: 1.06s;
               animation-delay: -.69s;
               animation-duration: 1.06s
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.41s;
               -webkit-animation-duration: 1.5s;
               animation-delay: -.41s;
               animation-duration: 1.5s
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: .04s;
               -webkit-animation-duration: 1.6s;
               animation-delay: .04s;
               animation-duration: 1.6s
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: .07s;
               -webkit-animation-duration: .84s;
               animation-delay: .07s;
               animation-duration: .84s
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -.66s;
               -webkit-animation-duration: .68s;
               animation-delay: -.66s;
               animation-duration: .68s
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: -.76s;
               -webkit-animation-duration: .93s;
               animation-delay: -.76s;
               animation-duration: .93s
          }
          
          .la-ball-grid-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(9) {
               -webkit-animation-delay: -.76s;
               -webkit-animation-duration: 1.24s;
               animation-delay: -.76s;
               animation-duration: 1.24s
          }
          
          .la-ball-grid-pulse.la-sm[_ngcontent-pjk-c38] {
               height: 18px;
               width: 18px
          }
          
          .la-ball-grid-pulse.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin: 1px;
               width: 4px
          }
          
          .la-ball-grid-pulse.la-2x[_ngcontent-pjk-c38] {
               height: 72px;
               width: 72px
          }
          
          .la-ball-grid-pulse.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               margin: 4px;
               width: 16px
          }
          
          .la-ball-grid-pulse.la-3x[_ngcontent-pjk-c38] {
               height: 108px;
               width: 108px
          }
          
          .la-ball-grid-pulse.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 24px;
               margin: 6px;
               width: 24px
          }
          
          @-webkit-keyframes ball-grid-pulse {
               0% {
                    opacity: 1;
                    transform: scale(1)
               }
               50% {
                    opacity: .35;
                    transform: scale(.45)
               }
               to {
                    opacity: 1;
                    transform: scale(1)
               }
          }
          
          @keyframes ball-grid-pulse {
               0% {
                    opacity: 1;
                    transform: scale(1)
               }
               50% {
                    opacity: .35;
                    transform: scale(.45)
               }
               to {
                    opacity: 1;
                    transform: scale(1)
               }
          }
          
          .la-ball-newton-cradle[_ngcontent-pjk-c38],
          .la-ball-newton-cradle[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-newton-cradle[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-newton-cradle.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-newton-cradle[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-newton-cradle[_ngcontent-pjk-c38] {
               height: 10px;
               width: 40px
          }
          
          .la-ball-newton-cradle[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-radius: 100%;
               height: 10px;
               width: 10px
          }
          
          .la-ball-newton-cradle[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation: ball-newton-cradle-left 1s ease-out 0s infinite;
               animation: ball-newton-cradle-left 1s ease-out 0s infinite;
               transform: translateX(0)
          }
          
          .la-ball-newton-cradle[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               -webkit-animation: ball-newton-cradle-right 1s ease-out 0s infinite;
               animation: ball-newton-cradle-right 1s ease-out 0s infinite;
               transform: translateX(0)
          }
          
          .la-ball-newton-cradle.la-sm[_ngcontent-pjk-c38] {
               height: 4px;
               width: 20px
          }
          
          .la-ball-newton-cradle.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               width: 4px
          }
          
          .la-ball-newton-cradle.la-2x[_ngcontent-pjk-c38] {
               height: 20px;
               width: 80px
          }
          
          .la-ball-newton-cradle.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               width: 20px
          }
          
          .la-ball-newton-cradle.la-3x[_ngcontent-pjk-c38] {
               height: 30px;
               width: 120px
          }
          
          .la-ball-newton-cradle.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               width: 30px
          }
          
          @-webkit-keyframes ball-newton-cradle-left {
               25% {
                    -webkit-animation-timing-function: ease-in;
                    animation-timing-function: ease-in;
                    transform: translateX(-100%)
               }
               50% {
                    transform: translateX(0)
               }
          }
          
          @keyframes ball-newton-cradle-left {
               25% {
                    -webkit-animation-timing-function: ease-in;
                    animation-timing-function: ease-in;
                    transform: translateX(-100%)
               }
               50% {
                    transform: translateX(0)
               }
          }
          
          @-webkit-keyframes ball-newton-cradle-right {
               50% {
                    transform: translateX(0)
               }
               75% {
                    -webkit-animation-timing-function: ease-in;
                    animation-timing-function: ease-in;
                    transform: translateX(100%)
               }
               to {
                    transform: translateX(0)
               }
          }
          
          @keyframes ball-newton-cradle-right {
               50% {
                    transform: translateX(0)
               }
               75% {
                    -webkit-animation-timing-function: ease-in;
                    animation-timing-function: ease-in;
                    transform: translateX(100%)
               }
               to {
                    transform: translateX(0)
               }
          }
          
          .la-ball-pulse-rise[_ngcontent-pjk-c38],
          .la-ball-pulse-rise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-pulse-rise[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-pulse-rise.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-pulse-rise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-pulse-rise[_ngcontent-pjk-c38] {
               height: 14px;
               width: 70px
          }
          
          .la-ball-pulse-rise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-pulse-rise-even 1s cubic-bezier(.15, .36, .9, .6) 0s infinite;
               animation: ball-pulse-rise-even 1s cubic-bezier(.15, .36, .9, .6) 0s infinite;
               border-radius: 100%;
               height: 10px;
               margin: 2px;
               width: 10px
          }


          
          .la-ball-pulse-rise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2n-1) {
               -webkit-animation-name: ball-pulse-rise-odd;
               animation-name: ball-pulse-rise-odd
          }
          
          .la-ball-pulse-rise.la-sm[_ngcontent-pjk-c38] {
               height: 6px;
               width: 34px
          }
          
          .la-ball-pulse-rise.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin: 1px;
               width: 4px
          }
          
          .la-ball-pulse-rise.la-2x[_ngcontent-pjk-c38] {
               height: 28px;
               width: 140px
          }
          
          .la-ball-pulse-rise.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               margin: 4px;
               width: 20px
          }
          
          .la-ball-pulse-rise.la-3x[_ngcontent-pjk-c38] {
               height: 42px;
               width: 210px
          }
          
          .la-ball-pulse-rise.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               margin: 6px;
               width: 30px
          }
          
          @-webkit-keyframes ball-pulse-rise-even {
               0% {
                    opacity: 1;
                    transform: scale(1.1)
               }
               25% {
                    transform: translateY(-200%)
               }
               50% {
                    opacity: .35;
                    transform: scale(.3)
               }
               75% {
                    transform: translateY(200%)
               }
               to {
                    opacity: 1;
                    transform: translateY(0);
                    transform: scale(1)
               }
          }
          
          @keyframes ball-pulse-rise-even {
               0% {
                    opacity: 1;
                    transform: scale(1.1)
               }
               25% {
                    transform: translateY(-200%)
               }
               50% {
                    opacity: .35;
                    transform: scale(.3)
               }
               75% {
                    transform: translateY(200%)
               }
               to {
                    opacity: 1;
                    transform: translateY(0);
                    transform: scale(1)
               }
          }
          
          @-webkit-keyframes ball-pulse-rise-odd {
               0% {
                    opacity: .35;
                    transform: scale(.4)
               }
               25% {
                    transform: translateY(200%)
               }
               50% {
                    opacity: 1;
                    transform: scale(1.1)
               }
               75% {
                    transform: translateY(-200%)
               }
               to {
                    opacity: .35;
                    transform: translateY(0);
                    transform: scale(.75)
               }
          }
          
          @keyframes ball-pulse-rise-odd {
               0% {
                    opacity: .35;
                    transform: scale(.4)
               }
               25% {
                    transform: translateY(200%)
               }
               50% {
                    opacity: 1;
                    transform: scale(1.1)
               }
               75% {
                    transform: translateY(-200%)
               }
               to {
                    opacity: .35;
                    transform: translateY(0);
                    transform: scale(.75)
               }
          }
          
          .la-ball-pulse-sync[_ngcontent-pjk-c38],
          .la-ball-pulse-sync[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-pulse-sync[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-pulse-sync.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-pulse-sync[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-pulse-sync[_ngcontent-pjk-c38] {
               height: 18px;
               width: 54px
          }
          
          .la-ball-pulse-sync[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-pulse-sync .6s ease-in-out infinite;
               animation: ball-pulse-sync .6s ease-in-out infinite;
               border-radius: 100%;
               height: 10px;
               margin: 4px;
               width: 10px
          }
          
          .la-ball-pulse-sync[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -.14s;
               animation-delay: -.14s
          }
          
          .la-ball-pulse-sync[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.07s;
               animation-delay: -.07s
          }
          
          .la-ball-pulse-sync[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: 0s;
               animation-delay: 0s
          }
          
          .la-ball-pulse-sync.la-sm[_ngcontent-pjk-c38] {
               height: 8px;
               width: 26px
          }
          
          .la-ball-pulse-sync.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin: 2px;
               width: 4px
          }
          
          .la-ball-pulse-sync.la-2x[_ngcontent-pjk-c38] {
               height: 36px;
               width: 108px
          }
          
          .la-ball-pulse-sync.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               margin: 8px;
               width: 20px
          }
          
          .la-ball-pulse-sync.la-3x[_ngcontent-pjk-c38] {
               height: 54px;
               width: 162px
          }
          
          .la-ball-pulse-sync.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               margin: 12px;
               width: 30px
          }
          
          @-webkit-keyframes ball-pulse-sync {
               33% {
                    transform: translateY(100%)
               }
               66% {
                    transform: translateY(-100%)
               }
               to {
                    transform: translateY(0)
               }
          }
          
          @keyframes ball-pulse-sync {
               33% {
                    transform: translateY(100%)
               }
               66% {
                    transform: translateY(-100%)
               }
               to {
                    transform: translateY(0)
               }
          }
          
          .la-ball-pulse[_ngcontent-pjk-c38],
          .la-ball-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-pulse[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-pulse.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-pulse[_ngcontent-pjk-c38] {
               height: 18px;
               width: 54px
          }
          
          .la-ball-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -.2s;
               animation-delay: -.2s
          }
          
          .la-ball-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.1s;
               animation-delay: -.1s
          }
          
          .la-ball-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: 0ms;
               animation-delay: 0ms
          }
          
          .la-ball-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-pulse 1s ease infinite;
               animation: ball-pulse 1s ease infinite;
               border-radius: 100%;
               height: 10px;
               margin: 4px;
               width: 10px
          }
          
          .la-ball-pulse.la-sm[_ngcontent-pjk-c38] {
               height: 8px;
               width: 26px
          }
          
          .la-ball-pulse.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin: 2px;
               width: 4px
          }
          
          .la-ball-pulse.la-2x[_ngcontent-pjk-c38] {
               height: 36px;
               width: 108px
          }
          
          .la-ball-pulse.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               margin: 8px;
               width: 20px
          }
          
          .la-ball-pulse.la-3x[_ngcontent-pjk-c38] {
               height: 54px;
               width: 162px
          }
          
          .la-ball-pulse.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               margin: 12px;
               width: 30px
          }
          
          @-webkit-keyframes ball-pulse {
               0%,
               60%,
               to {
                    opacity: 1;
                    transform: scale(1)
               }
               30% {
                    opacity: .1;
                    transform: scale(.01)
               }
          }
          
          @keyframes ball-pulse {
               0%,
               60%,
               to {
                    opacity: 1;
                    transform: scale(1)
               }
               30% {
                    opacity: .1;
                    transform: scale(.01)
               }
          }
          
          .la-ball-rotate[_ngcontent-pjk-c38],
          .la-ball-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-rotate[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-rotate.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-rotate[_ngcontent-pjk-c38],
          .la-ball-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 10px;
               width: 10px
          }
          
          .la-ball-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-rotate-animation 1s cubic-bezier(.7, -.13, .22, .86) infinite;
               animation: ball-rotate-animation 1s cubic-bezier(.7, -.13, .22, .86) infinite;
               border-radius: 100%
          }
          
          .la-ball-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after,
          .la-ball-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:before {

               background: currentColor;
               border-radius: inherit;
               content: "";
               height: inherit;
               margin: inherit;
               opacity: .8;
               position: absolute;
               width: inherit
          }
          
          .la-ball-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:before {
               left: -150%;
               top: 0
          }
          
          .la-ball-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after {
               left: 150%;
               top: 0
          }
          
          .la-ball-rotate.la-sm[_ngcontent-pjk-c38],
          .la-ball-rotate.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               width: 4px
          }
          
          .la-ball-rotate.la-2x[_ngcontent-pjk-c38],
          .la-ball-rotate.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               width: 20px
          }
          
          .la-ball-rotate.la-3x[_ngcontent-pjk-c38],
          .la-ball-rotate.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               width: 30px
          }
          
          @-webkit-keyframes ball-rotate-animation {
               0% {
                    transform: rotate(0deg)
               }
               50% {
                    transform: rotate(180deg)
               }
               to {
                    transform: rotate(1turn)
               }
          }
          
          @keyframes ball-rotate-animation {
               0% {
                    transform: rotate(0deg)
               }
               50% {
                    transform: rotate(180deg)
               }
               to {
                    transform: rotate(1turn)
               }
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38],
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-running-dots.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38] {
               height: 10px;
               width: 10px
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-running-dots-animate 2s linear infinite;
               animation: ball-running-dots-animate 2s linear infinite;
               border-radius: 100%;
               height: 10px;
               margin-left: -25px;
               position: absolute;
               width: 10px
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: 0s;
               animation-delay: 0s
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.4s;
               animation-delay: -.4s
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.8s;
               animation-delay: -.8s
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -1.2s;
               animation-delay: -1.2s
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -1.6s;
               animation-delay: -1.6s
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -2s;
               animation-delay: -2s
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -2.4s;
               animation-delay: -2.4s
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: -2.8s;
               animation-delay: -2.8s
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(9) {
               -webkit-animation-delay: -3.2s;
               animation-delay: -3.2s
          }
          
          .la-ball-running-dots[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(10) {
               -webkit-animation-delay: -3.6s;
               animation-delay: -3.6s
          }
          
          .la-ball-running-dots.la-sm[_ngcontent-pjk-c38] {
               height: 4px;
               width: 4px
          }
          
          .la-ball-running-dots.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: -12px;
               width: 4px
          }
          
          .la-ball-running-dots.la-2x[_ngcontent-pjk-c38] {
               height: 20px;
               width: 20px
          }
          
          .la-ball-running-dots.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               margin-left: -50px;
               width: 20px
          }
          
          .la-ball-running-dots.la-3x[_ngcontent-pjk-c38] {
               height: 30px;
               width: 30px
          }
          
          .la-ball-running-dots.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               margin-left: -75px;
               width: 30px
          }
          
          @-webkit-keyframes ball-running-dots-animate {
               0%,
               to {
                    height: 100%;
                    transform: translateY(0) translateX(500%);
                    width: 100%
               }
               80% {
                    transform: translateY(0) translateX(0)
               }
               85% {
                    height: 100%;
                    transform: translateY(-125%) translateX(0);
                    width: 100%
               }
               90% {
                    height: 75%;
                    width: 200%
               }
               95% {
                    height: 100%;
                    transform: translateY(-100%) translateX(500%);
                    width: 100%
               }
          }
          
          @keyframes ball-running-dots-animate {
               0%,
               to {
                    height: 100%;
                    transform: translateY(0) translateX(500%);
                    width: 100%
               }
               80% {
                    transform: translateY(0) translateX(0)
               }
               85% {
                    height: 100%;
                    transform: translateY(-125%) translateX(0);
                    width: 100%
               }
               90% {
                    height: 75%;
                    width: 200%
               }
               95% {
                    height: 100%;
                    transform: translateY(-100%) translateX(500%);
                    width: 100%
               }
          }
          
          .la-ball-scale-multiple[_ngcontent-pjk-c38],
          .la-ball-scale-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-scale-multiple[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-scale-multiple.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-scale-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-scale-multiple[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-scale-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-scale-multiple 1s linear 0s infinite;
               animation: ball-scale-multiple 1s linear 0s infinite;
               border-radius: 100%;
               height: 32px;
               left: 0;
               opacity: 0;
               position: absolute;
               top: 0;
               width: 32px
          }
          
          .la-ball-scale-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: .2s;
               animation-delay: .2s
          }
          
          .la-ball-scale-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: .4s;
               animation-delay: .4s
          }
          
          .la-ball-scale-multiple.la-sm[_ngcontent-pjk-c38],
          .la-ball-scale-multiple.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-scale-multiple.la-2x[_ngcontent-pjk-c38],
          .la-ball-scale-multiple.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-scale-multiple.la-3x[_ngcontent-pjk-c38],
          .la-ball-scale-multiple.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          @-webkit-keyframes ball-scale-multiple {
               0% {
                    opacity: 0;
                    transform: scale(0)
               }
               5% {
                    opacity: .75
               }
               to {
                    opacity: 0;
                    transform: scale(1)
               }
          }
          
          @keyframes ball-scale-multiple {
               0% {
                    opacity: 0;
                    transform: scale(0)
               }
               5% {
                    opacity: .75
               }
               to {
                    opacity: 0;
                    transform: scale(1)
               }
          }
          
          .la-ball-scale-pulse[_ngcontent-pjk-c38],
          .la-ball-scale-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-scale-pulse[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-scale-pulse.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-scale-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-scale-pulse[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-scale-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-scale-pulse 2s ease-in-out infinite;
               animation: ball-scale-pulse 2s ease-in-out infinite;
               border-radius: 100%;
               height: 32px;
               left: 0;
               opacity: .5;
               position: absolute;
               top: 0;
               width: 32px
          }
          
          .la-ball-scale-pulse[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               -webkit-animation-delay: -1s;
               animation-delay: -1s
          }
          
          .la-ball-scale-pulse.la-sm[_ngcontent-pjk-c38],
          .la-ball-scale-pulse.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-scale-pulse.la-2x[_ngcontent-pjk-c38],
          .la-ball-scale-pulse.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-scale-pulse.la-3x[_ngcontent-pjk-c38],
          .la-ball-scale-pulse.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          @-webkit-keyframes ball-scale-pulse {
               0%,
               to {
                    transform: scale(0)
               }
               50% {
                    transform: scale(1)
               }
          }
          
          @keyframes ball-scale-pulse {
               0%,
               to {
                    transform: scale(0)
               }
               50% {
                    transform: scale(1)
               }
          }
          
          .la-ball-scale-ripple-multiple[_ngcontent-pjk-c38],
          .la-ball-scale-ripple-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-scale-ripple-multiple[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-scale-ripple-multiple.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-scale-ripple-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-scale-ripple-multiple[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-scale-ripple-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-scale-ripple-multiple 1.25s cubic-bezier(.21, .53, .56, .8) 0s infinite;
               animation: ball-scale-ripple-multiple 1.25s cubic-bezier(.21, .53, .56, .8) 0s infinite;
               background: transparent;
               border-radius: 100%;
               border-width: 2px;
               height: 32px;
               left: 0;
               opacity: 0;
               position: absolute;
               top: 0;
               width: 32px
          }
          
          .la-ball-scale-ripple-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: 0s;
               animation-delay: 0s
          }
          
          .la-ball-scale-ripple-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: .25s;
               animation-delay: .25s
          }
          
          .la-ball-scale-ripple-multiple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: .5s;
               animation-delay: .5s
          }
          
          .la-ball-scale-ripple-multiple.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-scale-ripple-multiple.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 1px;
               height: 16px;
               width: 16px
          }
          
          .la-ball-scale-ripple-multiple.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-scale-ripple-multiple.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 4px;
               height: 64px;
               width: 64px
          }
          
          .la-ball-scale-ripple-multiple.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-scale-ripple-multiple.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 6px;
               height: 96px;
               width: 96px
          }
          
          @-webkit-keyframes ball-scale-ripple-multiple {
               0% {
                    opacity: 1;
                    transform: scale(.1)
               }
               70% {
                    opacity: .5;
                    transform: scale(1)
               }
               95% {
                    opacity: 0
               }
          }
          
          @keyframes ball-scale-ripple-multiple {
               0% {
                    opacity: 1;
                    transform: scale(.1)
               }
               70% {
                    opacity: .5;
                    transform: scale(1)
               }
               95% {
                    opacity: 0
               }
          }
          
          .la-ball-scale-ripple[_ngcontent-pjk-c38],
          .la-ball-scale-ripple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-scale-ripple[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-scale-ripple.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-scale-ripple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-scale-ripple[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-scale-ripple[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-scale-ripple 1s cubic-bezier(.21, .53, .56, .8) 0s infinite;
               animation: ball-scale-ripple 1s cubic-bezier(.21, .53, .56, .8) 0s infinite;
               background: transparent;
               border-radius: 100%;
               border-width: 2px;
               height: 32px;
               opacity: 0;
               width: 32px
          }
          
          .la-ball-scale-ripple.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-scale-ripple.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 1px;
               height: 16px;
               width: 16px
          }
          
          .la-ball-scale-ripple.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-scale-ripple.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 4px;
               height: 64px;
               width: 64px
          }
          
          .la-ball-scale-ripple.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-scale-ripple.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 6px;
               height: 96px;
               width: 96px
          }
          
          @-webkit-keyframes ball-scale-ripple {
               0% {
                    opacity: 1;
                    transform: scale(.1)
               }
               70% {
                    opacity: .65;
                    transform: scale(1)
               }
               to {
                    opacity: 0
               }
          }
          
          @keyframes ball-scale-ripple {
               0% {
                    opacity: 1;
                    transform: scale(.1)
               }
               70% {
                    opacity: .65;
                    transform: scale(1)
               }
               to {
                    opacity: 0
               }
          }
          
          .la-ball-scale[_ngcontent-pjk-c38],
          .la-ball-scale[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-scale[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-scale.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-scale[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-scale[_ngcontent-pjk-c38],
          .la-ball-scale[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-scale[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-scale 1s ease-in-out 0s infinite;
               animation: ball-scale 1s ease-in-out 0s infinite;
               border-radius: 100%;
               opacity: 0
          }
          
          .la-ball-scale.la-sm[_ngcontent-pjk-c38],
          .la-ball-scale.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-scale.la-2x[_ngcontent-pjk-c38],
          .la-ball-scale.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-scale.la-3x[_ngcontent-pjk-c38],
          .la-ball-scale.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          @-webkit-keyframes ball-scale {
               0% {
                    opacity: 1;
                    transform: scale(0)
               }
               to {
                    opacity: 0;
                    transform: scale(1)
               }
          }
          
          @keyframes ball-scale {
               0% {
                    opacity: 1;
                    transform: scale(0)
               }
               to {
                    opacity: 0;
                    transform: scale(1)
               }
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38],
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-spin-clockwise-fade-rotating.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38] {
               -webkit-animation: ball-spin-clockwise-fade-rotating-rotate 6s linear infinite;
               animation: ball-spin-clockwise-fade-rotating-rotate 6s linear infinite;
               height: 32px;
               width: 32px
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-spin-clockwise-fade-rotating 1s linear infinite;
               animation: ball-spin-clockwise-fade-rotating 1s linear infinite;
               border-radius: 100%;
               height: 8px;
               left: 50%;
               margin-left: -4px;
               margin-top: -4px;
               position: absolute;
               top: 50%;
               width: 8px
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -.875s;
               animation-delay: -.875s;
               left: 50%;
               top: 5%
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.75s;
               animation-delay: -.75s;
               left: 81.8198051534%;
               top: 18.1801948466%
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.625s;
               animation-delay: -.625s;
               left: 95%;
               top: 50%
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.5s;
               animation-delay: -.5s;
               left: 81.8198051534%;
               top: 81.8198051534%
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -.375s;
               animation-delay: -.375s;
               left: 50.0000000005%;
               top: 94.9999999966%
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -.25s;
               animation-delay: -.25s;
               left: 18.1801949248%;
               top: 81.8198046966%
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -.125s;
               animation-delay: -.125s;
               left: 5.0000051215%;
               top: 49.9999750815%
          }
          
          .la-ball-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: 0s;
               animation-delay: 0s;
               left: 18.1803700518%;
               top: 18.179464974%
          }
          
          .la-ball-spin-clockwise-fade-rotating.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-spin-clockwise-fade-rotating.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: -2px;
               margin-top: -2px;
               width: 4px
          }
          
          .la-ball-spin-clockwise-fade-rotating.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-spin-clockwise-fade-rotating.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               margin-left: -8px;
               margin-top: -8px;
               width: 16px
          }
          
          .la-ball-spin-clockwise-fade-rotating.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-spin-clockwise-fade-rotating.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 24px;
               margin-left: -12px;
               margin-top: -12px;
               width: 24px
          }
          
          @-webkit-keyframes ball-spin-clockwise-fade-rotating-rotate {
               to {
                    transform: rotate(-1turn)
               }
          }
          
          @keyframes ball-spin-clockwise-fade-rotating-rotate {
               to {
                    transform: rotate(-1turn)
               }
          }
          
          @-webkit-keyframes ball-spin-clockwise-fade-rotating {
               50% {
                    opacity: .25;
                    transform: scale(.5)
               }
               to {
                    opacity: 1;
                    transform: scale(1)
               }
          }
          
          @keyframes ball-spin-clockwise-fade-rotating {
               50% {
                    opacity: .25;
                    transform: scale(.5)
               }
               to {
                    opacity: 1;
                    transform: scale(1)
               }
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38],
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-spin-clockwise-fade.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-spin-clockwise-fade 1s linear infinite;
               animation: ball-spin-clockwise-fade 1s linear infinite;
               border-radius: 100%;
               height: 8px;
               left: 50%;
               margin-left: -4px;
               margin-top: -4px;
               position: absolute;
               top: 50%;
               width: 8px
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -.875s;
               animation-delay: -.875s;
               left: 50%;
               top: 5%
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.75s;
               animation-delay: -.75s;
               left: 81.8198051534%;
               top: 18.1801948466%
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.625s;
               animation-delay: -.625s;
               left: 95%;
               top: 50%
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.5s;
               animation-delay: -.5s;
               left: 81.8198051534%;
               top: 81.8198051534%
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -.375s;
               animation-delay: -.375s;
               left: 50.0000000005%;
               top: 94.9999999966%
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -.25s;
               animation-delay: -.25s;
               left: 18.1801949248%;
               top: 81.8198046966%
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -.125s;
               animation-delay: -.125s;
               left: 5.0000051215%;
               top: 49.9999750815%
          }
          
          .la-ball-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: 0s;
               animation-delay: 0s;
               left: 18.1803700518%;
               top: 18.179464974%
          }
          
          .la-ball-spin-clockwise-fade.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-spin-clockwise-fade.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: -2px;
               margin-top: -2px;
               width: 4px
          }
          
          .la-ball-spin-clockwise-fade.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-spin-clockwise-fade.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               margin-left: -8px;
               margin-top: -8px;
               width: 16px
          }
          
          .la-ball-spin-clockwise-fade.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-spin-clockwise-fade.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 24px;
               margin-left: -12px;
               margin-top: -12px;
               width: 24px
          }
          
          @-webkit-keyframes ball-spin-clockwise-fade {
               50% {
                    opacity: .25;
                    transform: scale(.5)
               }
               to {
                    opacity: 1;
                    transform: scale(1)
               }
          }
          
          @keyframes ball-spin-clockwise-fade {
               50% {
                    opacity: .25;
                    transform: scale(.5)
               }
               to {
                    opacity: 1;
                    transform: scale(1)
               }
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38],
          .la-ball-spin-clockwise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-spin-clockwise.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-spin-clockwise 1s ease-in-out infinite;
               animation: ball-spin-clockwise 1s ease-in-out infinite;
               border-radius: 100%;
               height: 8px;
               left: 50%;
               margin-left: -4px;
               margin-top: -4px;
               position: absolute;
               top: 50%;
               width: 8px
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -.875s;
               animation-delay: -.875s;
               left: 50%;
               top: 5%
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.75s;
               animation-delay: -.75s;
               left: 81.8198051534%;
               top: 18.1801948466%
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.625s;
               animation-delay: -.625s;
               left: 95%;
               top: 50%
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.5s;
               animation-delay: -.5s;
               left: 81.8198051534%;
               top: 81.8198051534%
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -.375s;
               animation-delay: -.375s;
               left: 50.0000000005%;
               top: 94.9999999966%
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -.25s;
               animation-delay: -.25s;
               left: 18.1801949248%;
               top: 81.8198046966%
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -.125s;
               animation-delay: -.125s;
               left: 5.0000051215%;
               top: 49.9999750815%
          }
          
          .la-ball-spin-clockwise[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: 0s;
               animation-delay: 0s;
               left: 18.1803700518%;
               top: 18.179464974%
          }
          
          .la-ball-spin-clockwise.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-spin-clockwise.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: -2px;
               margin-top: -2px;
               width: 4px
          }
          
          .la-ball-spin-clockwise.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-spin-clockwise.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               margin-left: -8px;
               margin-top: -8px;
               width: 16px
          }
          
          .la-ball-spin-clockwise.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-spin-clockwise.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 24px;
               margin-left: -12px;
               margin-top: -12px;
               width: 24px
          }
          
          @-webkit-keyframes ball-spin-clockwise {
               0%,
               to {
                    opacity: 1;
                    transform: scale(1)
               }
               20% {
                    opacity: 1
               }
               80% {
                    opacity: 0;
                    transform: scale(0)
               }
          }
          
          @keyframes ball-spin-clockwise {
               0%,
               to {
                    opacity: 1;
                    transform: scale(1)
               }
               20% {
                    opacity: 1
               }
               80% {
                    opacity: 0;
                    transform: scale(0)
               }
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38],
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-spin-fade-rotating.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38] {
               -webkit-animation: ball-spin-fade-rotate 6s linear infinite;
               animation: ball-spin-fade-rotate 6s linear infinite;
               height: 32px;
               width: 32px
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-spin-fade 1s linear infinite;
               animation: ball-spin-fade 1s linear infinite;
               border-radius: 100%;
               height: 8px;
               left: 50%;
               margin-left: -4px;
               margin-top: -4px;
               position: absolute;
               top: 50%;
               width: 8px
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -1.125s;
               animation-delay: -1.125s;
               left: 50%;
               top: 5%
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -1.25s;
               animation-delay: -1.25s;
               left: 81.8198051534%;
               top: 18.1801948466%
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -1.375s;
               animation-delay: -1.375s;
               left: 95%;
               top: 50%
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -1.5s;
               animation-delay: -1.5s;
               left: 81.8198051534%;
               top: 81.8198051534%
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -1.625s;
               animation-delay: -1.625s;
               left: 50.0000000005%;
               top: 94.9999999966%
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -1.75s;
               animation-delay: -1.75s;
               left: 18.1801949248%;
               top: 81.8198046966%
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -1.875s;
               animation-delay: -1.875s;
               left: 5.0000051215%;
               top: 49.9999750815%
          }
          
          .la-ball-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: -2s;
               animation-delay: -2s;
               left: 18.1803700518%;
               top: 18.179464974%
          }
          
          .la-ball-spin-fade-rotating.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-spin-fade-rotating.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: -2px;
               margin-top: -2px;
               width: 4px
          }
          
          .la-ball-spin-fade-rotating.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-spin-fade-rotating.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               margin-left: -8px;
               margin-top: -8px;
               width: 16px
          }
          
          .la-ball-spin-fade-rotating.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-spin-fade-rotating.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 24px;
               margin-left: -12px;
               margin-top: -12px;
               width: 24px
          }
          
          @-webkit-keyframes ball-spin-fade-rotate {
               to {
                    transform: rotate(1turn)
               }
          }
          
          @keyframes ball-spin-fade-rotate {
               to {
                    transform: rotate(1turn)
               }
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38],
          .la-ball-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-spin-fade.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-spin-fade 1s linear infinite;
               animation: ball-spin-fade 1s linear infinite;
               border-radius: 100%;
               height: 8px;
               left: 50%;
               margin-left: -4px;
               margin-top: -4px;
               position: absolute;
               top: 50%;
               width: 8px
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -1.125s;
               animation-delay: -1.125s;
               left: 50%;
               top: 5%
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -1.25s;
               animation-delay: -1.25s;
               left: 81.8198051534%;
               top: 18.1801948466%
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -1.375s;
               animation-delay: -1.375s;
               left: 95%;
               top: 50%
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -1.5s;
               animation-delay: -1.5s;
               left: 81.8198051534%;
               top: 81.8198051534%
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -1.625s;
               animation-delay: -1.625s;
               left: 50.0000000005%;
               top: 94.9999999966%
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -1.75s;
               animation-delay: -1.75s;
               left: 18.1801949248%;
               top: 81.8198046966%
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -1.875s;
               animation-delay: -1.875s;
               left: 5.0000051215%;
               top: 49.9999750815%
          }
          
          .la-ball-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: -2s;
               animation-delay: -2s;
               left: 18.1803700518%;
               top: 18.179464974%
          }
          
          .la-ball-spin-fade.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-spin-fade.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: -2px;
               margin-top: -2px;
               width: 4px
          }
          
          .la-ball-spin-fade.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-spin-fade.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               margin-left: -8px;
               margin-top: -8px;
               width: 16px
          }
          
          .la-ball-spin-fade.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-spin-fade.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 24px;
               margin-left: -12px;
               margin-top: -12px;
               width: 24px
          }
          
          @-webkit-keyframes ball-spin-fade {
               0%,
               to {
                    opacity: 1;
                    transform: scale(1)
               }
               50% {
                    opacity: .25;
                    transform: scale(.5)
               }
          }
          
          @keyframes ball-spin-fade {
               0%,
               to {
                    opacity: 1;
                    transform: scale(1)
               }
               50% {
                    opacity: .25;
                    transform: scale(.5)
               }
          }
          
          .la-ball-spin-rotate[_ngcontent-pjk-c38],
          .la-ball-spin-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-spin-rotate[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-spin-rotate.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-spin-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-spin-rotate[_ngcontent-pjk-c38] {
               -webkit-animation: ball-spin-rotate 2s linear infinite;
               animation: ball-spin-rotate 2s linear infinite;
               height: 32px;
               width: 32px
          }
          
          .la-ball-spin-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-spin-bounce 2s ease-in-out infinite;
               animation: ball-spin-bounce 2s ease-in-out infinite;
               border-radius: 100%;
               height: 60%;
               position: absolute;
               top: 0;
               width: 60%
          }
          
          .la-ball-spin-rotate[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               -webkit-animation-delay: -1s;
               animation-delay: -1s;
               bottom: 0;
               top: auto
          }
          
          .la-ball-spin-rotate.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-spin-rotate.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-spin-rotate.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          @-webkit-keyframes ball-spin-rotate {
               to {
                    transform: rotate(1turn)
               }
          }
          
          @keyframes ball-spin-rotate {
               to {
                    transform: rotate(1turn)
               }
          }
          
          @-webkit-keyframes ball-spin-bounce {
               0%,
               to {
                    transform: scale(0)
               }
               50% {
                    transform: scale(1)
               }
          }
          
          @keyframes ball-spin-bounce {
               0%,
               to {
                    transform: scale(0)
               }
               50% {
                    transform: scale(1)
               }
          }
          
          .la-ball-spin[_ngcontent-pjk-c38],
          .la-ball-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-spin[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-spin.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-spin[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-spin 1s ease-in-out infinite;
               animation: ball-spin 1s ease-in-out infinite;
               border-radius: 100%;
               height: 8px;
               left: 50%;
               margin-left: -4px;
               margin-top: -4px;
               position: absolute;
               top: 50%;
               width: 8px
          }
          
          .la-ball-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -1.125s;
               animation-delay: -1.125s;
               left: 50%;
               top: 5%
          }
          
          .la-ball-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -1.25s;
               animation-delay: -1.25s;
               left: 81.8198051534%;
               top: 18.1801948466%
          }
          
          .la-ball-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -1.375s;
               animation-delay: -1.375s;
               left: 95%;
               top: 50%
          }
          
          .la-ball-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -1.5s;
               animation-delay: -1.5s;
               left: 81.8198051534%;
               top: 81.8198051534%
          }
          
          .la-ball-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -1.625s;
               animation-delay: -1.625s;
               left: 50.0000000005%;
               top: 94.9999999966%
          }
          
          .la-ball-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -1.75s;
               animation-delay: -1.75s;
               left: 18.1801949248%;
               top: 81.8198046966%
          }
          
          .la-ball-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -1.875s;
               animation-delay: -1.875s;
               left: 5.0000051215%;
               top: 49.9999750815%
          }
          
          .la-ball-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: -2s;
               animation-delay: -2s;
               left: 18.1803700518%;
               top: 18.179464974%
          }
          
          .la-ball-spin.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-spin.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: -2px;
               margin-top: -2px;
               width: 4px
          }
          
          .la-ball-spin.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-spin.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               margin-left: -8px;
               margin-top: -8px;
               width: 16px
          }
          
          .la-ball-spin.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-spin.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 24px;
               margin-left: -12px;
               margin-top: -12px;
               width: 24px
          }
          
          @-webkit-keyframes ball-spin {
               0%,
               to {
                    opacity: 1;
                    transform: scale(1)
               }
               20% {
                    opacity: 1
               }
               80% {
                    opacity: 0;
                    transform: scale(0)
               }
          }
          
          @keyframes ball-spin {
               0%,
               to {
                    opacity: 1;
                    transform: scale(1)
               }
               20% {
                    opacity: 1
               }
               80% {
                    opacity: 0;
                    transform: scale(0)
               }
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38],
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-square-clockwise-spin.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38] {
               height: 26px;
               width: 26px
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-square-clockwise-spin 1s ease-in-out infinite;
               animation: ball-square-clockwise-spin 1s ease-in-out infinite;
               border-radius: 100%;
               height: 12px;
               left: 50%;
               margin-left: -6px;
               margin-top: -6px;


               position: absolute;
               top: 50%;
               width: 12px
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -.875s;
               animation-delay: -.875s;
               left: 0;
               top: 0
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.75s;
               animation-delay: -.75s;
               left: 50%;
               top: 0
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.625s;
               animation-delay: -.625s;
               left: 100%;
               top: 0
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.5s;
               animation-delay: -.5s;
               left: 100%;
               top: 50%
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -.375s;
               animation-delay: -.375s;
               left: 100%;
               top: 100%
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -.25s;
               animation-delay: -.25s;
               left: 50%;
               top: 100%
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -.125s;
               animation-delay: -.125s;
               left: 0;
               top: 100%
          }
          
          .la-ball-square-clockwise-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: 0s;
               animation-delay: 0s;
               left: 0;
               top: 50%
          }
          
          .la-ball-square-clockwise-spin.la-sm[_ngcontent-pjk-c38] {
               height: 12px;
               width: 12px
          }
          
          .la-ball-square-clockwise-spin.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 6px;
               margin-left: -3px;
               margin-top: -3px;
               width: 6px
          }
          
          .la-ball-square-clockwise-spin.la-2x[_ngcontent-pjk-c38] {
               height: 52px;
               width: 52px
          }
          
          .la-ball-square-clockwise-spin.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 24px;
               margin-left: -12px;
               margin-top: -12px;
               width: 24px
          }
          
          .la-ball-square-clockwise-spin.la-3x[_ngcontent-pjk-c38] {
               height: 78px;
               width: 78px
          }
          
          .la-ball-square-clockwise-spin.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 36px;
               margin-left: -18px;
               margin-top: -18px;
               width: 36px
          }
          
          @-webkit-keyframes ball-square-clockwise-spin {
               0%,
               40%,
               to {
                    transform: scale(.4)
               }
               70% {
                    transform: scale(1)
               }
          }
          
          @keyframes ball-square-clockwise-spin {
               0%,
               40%,
               to {
                    transform: scale(.4)
               }
               70% {
                    transform: scale(1)
               }
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38],
          .la-ball-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-square-spin.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38] {
               height: 26px;
               width: 26px
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: ball-square-spin 1s ease-in-out infinite;
               animation: ball-square-spin 1s ease-in-out infinite;
               border-radius: 100%;
               height: 12px;
               left: 50%;
               margin-left: -6px;
               margin-top: -6px;
               position: absolute;
               top: 50%;
               width: 12px
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -1.125s;
               animation-delay: -1.125s;
               left: 0;
               top: 0
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -1.25s;
               animation-delay: -1.25s;
               left: 50%;
               top: 0
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -1.375s;
               animation-delay: -1.375s;
               left: 100%;
               top: 0
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -1.5s;
               animation-delay: -1.5s;
               left: 100%;
               top: 50%
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -1.625s;
               animation-delay: -1.625s;
               left: 100%;
               top: 100%
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -1.75s;
               animation-delay: -1.75s;
               left: 50%;
               top: 100%
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -1.875s;
               animation-delay: -1.875s;
               left: 0;
               top: 100%
          }
          
          .la-ball-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: -2s;
               animation-delay: -2s;
               left: 0;
               top: 50%
          }
          
          .la-ball-square-spin.la-sm[_ngcontent-pjk-c38] {
               height: 12px;
               width: 12px
          }
          
          .la-ball-square-spin.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 6px;
               margin-left: -3px;
               margin-top: -3px;
               width: 6px
          }
          
          .la-ball-square-spin.la-2x[_ngcontent-pjk-c38] {
               height: 52px;
               width: 52px
          }
          
          .la-ball-square-spin.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 24px;
               margin-left: -12px;
               margin-top: -12px;


               width: 24px
          }
          
          .la-ball-square-spin.la-3x[_ngcontent-pjk-c38] {
               height: 78px;
               width: 78px
          }
          
          .la-ball-square-spin.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 36px;
               margin-left: -18px;
               margin-top: -18px;
               width: 36px
          }
          
          @-webkit-keyframes ball-square-spin {
               0%,
               40%,
               to {
                    transform: scale(.4)
               }
               70% {
                    transform: scale(1)
               }
          }
          
          @keyframes ball-square-spin {
               0%,
               40%,
               to {
                    transform: scale(.4)
               }
               70% {
                    transform: scale(1)
               }
          }
          
          .la-ball-triangle-path[_ngcontent-pjk-c38],
          .la-ball-triangle-path[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-triangle-path[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-triangle-path.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-triangle-path[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-triangle-path[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-ball-triangle-path[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-radius: 100%;
               height: 10px;
               left: 0;
               position: absolute;
               top: 0;
               width: 10px
          }
          
          .la-ball-triangle-path[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation: ball-triangle-path-ball-one 2s ease-in-out 0s infinite;
               animation: ball-triangle-path-ball-one 2s ease-in-out 0s infinite
          }
          
          .la-ball-triangle-path[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation: ball-triangle-path-ball-two 2s ease-in-out 0s infinite;
               animation: ball-triangle-path-ball-two 2s ease-in-out 0s infinite
          }
          
          .la-ball-triangle-path[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation: ball-triangle-path-ball-tree 2s ease-in-out 0s infinite;
               animation: ball-triangle-path-ball-tree 2s ease-in-out 0s infinite
          }
          
          .la-ball-triangle-path.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-triangle-path.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               width: 4px
          }
          
          .la-ball-triangle-path.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-triangle-path.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               width: 20px
          }
          
          .la-ball-triangle-path.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-triangle-path.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               width: 30px
          }
          
          @-webkit-keyframes ball-triangle-path-ball-one {
               0% {
                    transform: translateY(220%)
               }
               17% {
                    opacity: .25
               }
               33% {
                    opacity: 1;
                    transform: translate(110%)
               }
               50% {
                    opacity: .25
               }
               66% {
                    opacity: 1;
                    transform: translate(220%, 220%)
               }
               83% {
                    opacity: .25
               }
               to {
                    opacity: 1;
                    transform: translateY(220%)
               }
          }
          
          @keyframes ball-triangle-path-ball-one {
               0% {
                    transform: translateY(220%)
               }
               17% {
                    opacity: .25
               }
               33% {
                    opacity: 1;
                    transform: translate(110%)
               }
               50% {
                    opacity: .25
               }
               66% {
                    opacity: 1;
                    transform: translate(220%, 220%)
               }
               83% {
                    opacity: .25
               }
               to {
                    opacity: 1;
                    transform: translateY(220%)
               }
          }
          
          @-webkit-keyframes ball-triangle-path-ball-two {
               0% {
                    transform: translate(110%)
               }
               17% {
                    opacity: .25
               }
               33% {
                    opacity: 1;
                    transform: translate(220%, 220%)
               }
               50% {
                    opacity: .25
               }
               66% {
                    opacity: 1;
                    transform: translateY(220%)
               }
               83% {
                    opacity: .25
               }
               to {
                    opacity: 1;
                    transform: translate(110%)
               }
          }
          
          @keyframes ball-triangle-path-ball-two {
               0% {
                    transform: translate(110%)
               }
               17% {
                    opacity: .25
               }
               33% {
                    opacity: 1;
                    transform: translate(220%, 220%)
               }
               50% {
                    opacity: .25
               }
               66% {
                    opacity: 1;
                    transform: translateY(220%)
               }
               83% {
                    opacity: .25
               }
               to {
                    opacity: 1;
                    transform: translate(110%)
               }
          }
          
          @-webkit-keyframes ball-triangle-path-ball-tree {
               0% {
                    transform: translate(220%, 220%)
               }
               17% {
                    opacity: .25
               }
               33% {
                    opacity: 1;
                    transform: translateY(220%)
               }
               50% {
                    opacity: .25
               }
               66% {
                    opacity: 1;
                    transform: translate(110%)
               }
               83% {
                    opacity: .25
               }
               to {
                    opacity: 1;
                    transform: translate(220%, 220%)
               }
          }
          
          @keyframes ball-triangle-path-ball-tree {
               0% {
                    transform: translate(220%, 220%)
               }
               17% {
                    opacity: .25
               }
               33% {
                    opacity: 1;
                    transform: translateY(220%)
               }
               50% {
                    opacity: .25
               }
               66% {
                    opacity: 1;
                    transform: translate(110%)
               }
               83% {
                    opacity: .25
               }
               to {
                    opacity: 1;
                    transform: translate(220%, 220%)
               }
          }
          
          .la-ball-zig-zag-deflect[_ngcontent-pjk-c38],
          .la-ball-zig-zag-deflect[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-zig-zag-deflect[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-zig-zag-deflect.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-zig-zag-deflect[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-zig-zag-deflect[_ngcontent-pjk-c38] {
               height: 32px;
               position: relative;
               width: 32px
          }
          
          .la-ball-zig-zag-deflect[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-radius: 100%;
               height: 10px;
               left: 50%;
               margin-left: -5px;
               margin-top: -5px;
               position: absolute;
               top: 50%;
               width: 10px
          }
          
          .la-ball-zig-zag-deflect[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation: ball-zig-deflect 1.5s linear 0s infinite;
               animation: ball-zig-deflect 1.5s linear 0s infinite
          }
          
          .la-ball-zig-zag-deflect[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               -webkit-animation: ball-zag-deflect 1.5s linear 0s infinite;
               animation: ball-zag-deflect 1.5s linear 0s infinite
          }
          
          .la-ball-zig-zag-deflect.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-zig-zag-deflect.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: -2px;
               margin-top: -2px;
               width: 4px
          }
          
          .la-ball-zig-zag-deflect.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-zig-zag-deflect.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               margin-left: -10px;
               margin-top: -10px;
               width: 20px
          }
          
          .la-ball-zig-zag-deflect.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-zig-zag-deflect.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               margin-left: -15px;
               margin-top: -15px;
               width: 30px
          }
          
          @-webkit-keyframes ball-zig-deflect {
               17% {
                    transform: translate(-80%, -160%)
               }
               34% {
                    transform: translate(80%, -160%)
               }
               50% {
                    transform: translate(0)
               }
               67% {
                    transform: translate(80%, -160%)
               }
               84% {
                    transform: translate(-80%, -160%)
               }
               to {
                    transform: translate(0)
               }
          }
          
          @keyframes ball-zig-deflect {
               17% {
                    transform: translate(-80%, -160%)
               }
               34% {
                    transform: translate(80%, -160%)
               }
               50% {
                    transform: translate(0)
               }
               67% {
                    transform: translate(80%, -160%)
               }
               84% {
                    transform: translate(-80%, -160%)
               }
               to {
                    transform: translate(0)
               }
          }
          
          @-webkit-keyframes ball-zag-deflect {
               17% {
                    transform: translate(80%, 160%)
               }
               34% {
                    transform: translate(-80%, 160%)
               }
               50% {
                    transform: translate(0)
               }
               67% {
                    transform: translate(-80%, 160%)
               }
               84% {
                    transform: translate(80%, 160%)
               }
               to {
                    transform: translate(0)
               }
          }
          
          @keyframes ball-zag-deflect {
               17% {
                    transform: translate(80%, 160%)
               }
               34% {
                    transform: translate(-80%, 160%)
               }
               50% {
                    transform: translate(0)
               }
               67% {
                    transform: translate(-80%, 160%)
               }
               84% {
                    transform: translate(80%, 160%)
               }
               to {
                    transform: translate(0)
               }
          }
          
          .la-ball-zig-zag[_ngcontent-pjk-c38],
          .la-ball-zig-zag[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-ball-zig-zag[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-ball-zig-zag.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-ball-zig-zag[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-ball-zig-zag[_ngcontent-pjk-c38] {
               height: 32px;
               position: relative;
               width: 32px
          }
          
          .la-ball-zig-zag[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-radius: 100%;
               height: 10px;
               left: 50%;
               margin-left: -5px;
               margin-top: -5px;
               position: absolute;
               top: 50%;
               width: 10px
          }
          
          .la-ball-zig-zag[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation: ball-zig-effect .7s linear 0s infinite;
               animation: ball-zig-effect .7s linear 0s infinite
          }
          
          .la-ball-zig-zag[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               -webkit-animation: ball-zag-effect .7s linear 0s infinite;
               animation: ball-zag-effect .7s linear 0s infinite
          }
          
          .la-ball-zig-zag.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-ball-zig-zag.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: -2px;
               margin-top: -2px;
               width: 4px
          }
          
          .la-ball-zig-zag.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-ball-zig-zag.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               margin-left: -10px;
               margin-top: -10px;
               width: 20px
          }
          
          .la-ball-zig-zag.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-ball-zig-zag.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               margin-left: -15px;
               margin-top: -15px;
               width: 30px
          }
          
          @-webkit-keyframes ball-zig-effect {
               0% {
                    transform: translate(0)
               }
               33% {
                    transform: translate(-75%, -150%)
               }
               66% {
                    transform: translate(75%, -150%)
               }
               to {
                    transform: translate(0)
               }
          }
          
          @keyframes ball-zig-effect {
               0% {
                    transform: translate(0)
               }
               33% {
                    transform: translate(-75%, -150%)
               }
               66% {
                    transform: translate(75%, -150%)
               }
               to {
                    transform: translate(0)
               }
          }
          
          @-webkit-keyframes ball-zag-effect {
               0% {
                    transform: translate(0)
               }
               33% {
                    transform: translate(75%, 150%)
               }
               66% {
                    transform: translate(-75%, 150%)
               }
               to {
                    transform: translate(0)
               }
          }
          
          @keyframes ball-zag-effect {
               0% {
                    transform: translate(0)
               }
               33% {
                    transform: translate(75%, 150%)
               }
               66% {
                    transform: translate(-75%, 150%)
               }
               to {
                    transform: translate(0)
               }
          }
          
          .la-cog[_ngcontent-pjk-c38],
          .la-cog[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-cog[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-cog.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-cog[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-cog[_ngcontent-pjk-c38] {
               height: 31px;
               width: 31px
          }
          
          .la-cog[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: cog-rotate 4s linear infinite;
               animation: cog-rotate 4s linear infinite;
               background-color: transparent;
               border-radius: 100%;
               border-style: dashed;
               border-width: 2px;
               height: 100%;
               width: 100%
          }
          
          .la-cog[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after {
               border: 2px solid;
               border-radius: 100%;
               content: "";
               height: 100%;
               left: 0;
               position: absolute;
               top: 0;
               width: 100%
          }
          
          .la-cog.la-sm[_ngcontent-pjk-c38] {
               height: 15px;
               width: 15px
          }
          
          .la-cog.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38],
          .la-cog.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after {
               border-width: 1px
          }
          
          .la-cog.la-2x[_ngcontent-pjk-c38] {
               height: 61px;
               width: 61px
          }
          
          .la-cog.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38],
          .la-cog.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after {
               border-width: 4px
          }
          
          .la-cog.la-3x[_ngcontent-pjk-c38] {
               height: 91px;
               width: 91px
          }
          
          .la-cog.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38],
          .la-cog.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after {
               border-width: 6px
          }
          
          @-webkit-keyframes cog-rotate {
               0% {
                    transform: rotate(0deg)
               }
               to {
                    transform: rotate(1turn)
               }
          }
          
          @keyframes cog-rotate {
               0% {
                    transform: rotate(0deg)
               }
               to {
                    transform: rotate(1turn)
               }
          }
          
          .la-cube-transition[_ngcontent-pjk-c38],
          .la-cube-transition[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-cube-transition[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-cube-transition.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-cube-transition[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-cube-transition[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-cube-transition[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: cube-transition 1.6s ease-in-out 0s infinite;
               animation: cube-transition 1.6s ease-in-out 0s infinite;
               border-radius: 0;
               height: 14px;
               left: 0;
               margin-left: -7px;
               margin-top: -7px;
               position: absolute;
               top: 0;
               width: 14px
          }
          
          .la-cube-transition[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:last-child {
               -webkit-animation-delay: -.8s;
               animation-delay: -.8s
          }
          
          .la-cube-transition.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-cube-transition.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 6px;
               margin-left: -3px;
               margin-top: -3px;
               width: 6px
          }
          
          .la-cube-transition.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-cube-transition.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 28px;
               margin-left: -14px;
               margin-top: -14px;
               width: 28px
          }
          
          .la-cube-transition.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-cube-transition.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 42px;
               margin-left: -21px;
               margin-top: -21px;
               width: 42px
          }
          
          @-webkit-keyframes cube-transition {
               25% {
                    left: 100%;

                    top: 0;
                    transform: scale(.5) rotate(-90deg)
               }
               50% {
                    left: 100%;
                    top: 100%;
                    transform: scale(1) rotate(-180deg)
               }
               75% {
                    left: 0;
                    top: 100%;
                    transform: scale(.5) rotate(-270deg)
               }
               to {
                    left: 0;
                    top: 0;
                    transform: scale(1) rotate(-1turn)
               }
          }
          
          @keyframes cube-transition {
               25% {
                    left: 100%;
                    top: 0;
                    transform: scale(.5) rotate(-90deg)
               }
               50% {
                    left: 100%;
                    top: 100%;
                    transform: scale(1) rotate(-180deg)
               }
               75% {
                    left: 0;
                    top: 100%;
                    transform: scale(.5) rotate(-270deg)
               }
               to {
                    left: 0;
                    top: 0;
                    transform: scale(1) rotate(-1turn)
               }
          }
          
          .la-fire[_ngcontent-pjk-c38],
          .la-fire[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-fire[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-fire.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-fire[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-fire[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-fire[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: fire-diamonds 1.5s linear infinite;
               animation: fire-diamonds 1.5s linear infinite;
               border-radius: 0;
               border-radius: 2px;
               bottom: 0;
               height: 12px;
               left: 50%;
               position: absolute;
               transform: translateY(0) translateX(-50%) rotate(45deg) scale(0);
               width: 12px
          }
          
          .la-fire[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -.85s;
               animation-delay: -.85s
          }
          
          .la-fire[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -1.85s;
               animation-delay: -1.85s
          }
          
          .la-fire[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -2.85s;
               animation-delay: -2.85s
          }
          
          .la-fire.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-fire.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 6px;
               width: 6px
          }
          
          .la-fire.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-fire.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 24px;
               width: 24px
          }
          
          .la-fire.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-fire.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 36px;
               width: 36px
          }
          
          @-webkit-keyframes fire-diamonds {
               0% {
                    transform: translateY(75%) translateX(-50%) rotate(45deg) scale(0)
               }
               50% {
                    transform: translateY(-87.5%) translateX(-50%) rotate(45deg) scale(1)
               }
               to {
                    transform: translateY(-212.5%) translateX(-50%) rotate(45deg) scale(0)
               }
          }
          
          @keyframes fire-diamonds {
               0% {
                    transform: translateY(75%) translateX(-50%) rotate(45deg) scale(0)
               }
               50% {
                    transform: translateY(-87.5%) translateX(-50%) rotate(45deg) scale(1)
               }
               to {
                    transform: translateY(-212.5%) translateX(-50%) rotate(45deg) scale(0)
               }
          }
          
          .la-line-scale-party[_ngcontent-pjk-c38],
          .la-line-scale-party[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-line-scale-party[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-line-scale-party.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-line-scale-party[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-line-scale-party[_ngcontent-pjk-c38] {
               height: 32px;
               width: 40px
          }
          
          .la-line-scale-party[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation-iteration-count: infinite;
               -webkit-animation-name: line-scale-party;
               animation-iteration-count: infinite;
               animation-name: line-scale-party;
               border-radius: 0;
               height: 32px;
               margin: 0 2px;
               width: 4px
          }
          
          .la-line-scale-party[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -.23s;
               -webkit-animation-duration: .43s;
               animation-delay: -.23s;
               animation-duration: .43s
          }
          
          .la-line-scale-party[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.32s;
               -webkit-animation-duration: .62s;
               animation-delay: -.32s;
               animation-duration: .62s
          }
          
          .la-line-scale-party[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.44s;
               -webkit-animation-duration: .43s;
               animation-delay: -.44s;
               animation-duration: .43s
          }
          
          .la-line-scale-party[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.31s;
               -webkit-animation-duration: .8s;
               animation-delay: -.31s;
               animation-duration: .8s
          }
          
          .la-line-scale-party[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -.24s;
               -webkit-animation-duration: .74s;
               animation-delay: -.24s;
               animation-duration: .74s
          }
          
          .la-line-scale-party.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 20px
          }
          
          .la-line-scale-party.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               margin: 0 1px;
               width: 2px
          }
          
          .la-line-scale-party.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 80px
          }
          
          .la-line-scale-party.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 64px;
               margin: 0 4px;
               width: 8px
          }
          
          .la-line-scale-party.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 120px
          }
          
          .la-line-scale-party.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 96px;
               margin: 0 6px;
               width: 12px
          }
          
          @-webkit-keyframes line-scale-party {
               0% {
                    transform: scaleY(1)
               }
               50% {
                    transform: scaleY(.3)
               }
               to {
                    transform: scaleY(1)
               }
          }
          
          @keyframes line-scale-party {
               0% {
                    transform: scaleY(1)
               }
               50% {
                    transform: scaleY(.3)
               }
               to {
                    transform: scaleY(1)
               }
          }
          
          .la-line-scale-pulse-out-rapid[_ngcontent-pjk-c38],
          .la-line-scale-pulse-out-rapid[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-line-scale-pulse-out-rapid[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-line-scale-pulse-out-rapid.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-line-scale-pulse-out-rapid[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-line-scale-pulse-out-rapid[_ngcontent-pjk-c38] {
               height: 32px;
               width: 40px
          }
          
          .la-line-scale-pulse-out-rapid[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: line-scale-pulse-out-rapid .9s cubic-bezier(.11, .49, .38, .78) infinite;
               animation: line-scale-pulse-out-rapid .9s cubic-bezier(.11, .49, .38, .78) infinite;
               border-radius: 0;
               height: 32px;
               margin: 0 2px;
               width: 4px
          }
          
          .la-line-scale-pulse-out-rapid[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.9s;
               animation-delay: -.9s
          }
          
          .la-line-scale-pulse-out-rapid[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2),
          .la-line-scale-pulse-out-rapid[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.65s;
               animation-delay: -.65s
          }
          
          .la-line-scale-pulse-out-rapid[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child,
          .la-line-scale-pulse-out-rapid[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -.4s;
               animation-delay: -.4s
          }
          
          .la-line-scale-pulse-out-rapid.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 20px
          }
          
          .la-line-scale-pulse-out-rapid.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               margin: 0 1px;
               width: 2px
          }
          
          .la-line-scale-pulse-out-rapid.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 80px
          }
          
          .la-line-scale-pulse-out-rapid.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 64px;
               margin: 0 4px;
               width: 8px
          }
          
          .la-line-scale-pulse-out-rapid.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 120px
          }
          
          .la-line-scale-pulse-out-rapid.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 96px;
               margin: 0 6px;
               width: 12px
          }
          
          @-webkit-keyframes line-scale-pulse-out-rapid {
               0% {
                    transform: scaley(1)
               }
               80% {
                    transform: scaley(.3)
               }
               90% {
                    transform: scaley(1)
               }
          }
          
          @keyframes line-scale-pulse-out-rapid {
               0% {
                    transform: scaley(1)
               }
               80% {
                    transform: scaley(.3)
               }
               90% {
                    transform: scaley(1)
               }
          }
          
          .la-line-scale-pulse-out[_ngcontent-pjk-c38],
          .la-line-scale-pulse-out[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-line-scale-pulse-out[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-line-scale-pulse-out.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-line-scale-pulse-out[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-line-scale-pulse-out[_ngcontent-pjk-c38] {
               height: 32px;
               width: 40px
          }
          
          .la-line-scale-pulse-out[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: line-scale-pulse-out .9s cubic-bezier(.85, .25, .37, .85) infinite;
               animation: line-scale-pulse-out .9s cubic-bezier(.85, .25, .37, .85) infinite;
               border-radius: 0;
               height: 32px;
               margin: 0 2px;
               width: 4px
          }
          
          .la-line-scale-pulse-out[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.9s;
               animation-delay: -.9s
          }
          
          .la-line-scale-pulse-out[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2),
          .la-line-scale-pulse-out[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.7s;
               animation-delay: -.7s
          }
          
          .la-line-scale-pulse-out[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child,
          .la-line-scale-pulse-out[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -.5s;
               animation-delay: -.5s
          }
          
          .la-line-scale-pulse-out.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 20px
          }
          
          .la-line-scale-pulse-out.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               margin: 0 1px;
               width: 2px
          }
          
          .la-line-scale-pulse-out.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 80px
          }
          
          .la-line-scale-pulse-out.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 64px;
               margin: 0 4px;
               width: 8px
          }
          
          .la-line-scale-pulse-out.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 120px
          }
          
          .la-line-scale-pulse-out.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 96px;
               margin: 0 6px;
               width: 12px
          }
          
          @-webkit-keyframes line-scale-pulse-out {
               0% {
                    transform: scaley(1)
               }
               50% {
                    transform: scaley(.3)
               }
               to {
                    transform: scaley(1)
               }
          }
          
          @keyframes line-scale-pulse-out {
               0% {
                    transform: scaley(1)
               }
               50% {
                    transform: scaley(.3)
               }
               to {
                    transform: scaley(1)
               }
          }
          
          .la-line-scale[_ngcontent-pjk-c38],
          .la-line-scale[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-line-scale[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-line-scale.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-line-scale[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-line-scale[_ngcontent-pjk-c38] {
               height: 32px;
               width: 40px
          }
          
          .la-line-scale[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: line-scale 1.2s ease infinite;
               animation: line-scale 1.2s ease infinite;
               border-radius: 0;
               height: 32px;
               margin: 0 2px;
               width: 4px
          }
          
          .la-line-scale[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -1.2s;
               animation-delay: -1.2s
          }
          
          .la-line-scale[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -1.1s;
               animation-delay: -1.1s
          }
          
          .la-line-scale[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -1s;
               animation-delay: -1s
          }
          
          .la-line-scale[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.9s;
               animation-delay: -.9s
          }
          
          .la-line-scale[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -.8s;
               animation-delay: -.8s
          }
          
          .la-line-scale.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 20px
          }
          
          .la-line-scale.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               margin: 0 1px;
               width: 2px
          }
          
          .la-line-scale.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 80px
          }
          
          .la-line-scale.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 64px;
               margin: 0 4px;
               width: 8px
          }
          
          .la-line-scale.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 120px
          }
          
          .la-line-scale.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 96px;
               margin: 0 6px;
               width: 12px
          }
          
          @-webkit-keyframes line-scale {
               0%,
               40%,
               to {
                    transform: scaleY(.4)
               }
               20% {
                    transform: scaleY(1)
               }
          }
          
          @keyframes line-scale {
               0%,
               40%,
               to {
                    transform: scaleY(.4)
               }
               20% {
                    transform: scaleY(1)
               }
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38],
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-line-spin-clockwise-fade-rotating.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38] {
               -webkit-animation: line-spin-clockwise-fade-rotating-rotate 6s linear infinite;
               animation: line-spin-clockwise-fade-rotating-rotate 6s linear infinite;
               height: 32px;
               width: 32px
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: line-spin-clockwise-fade-rotating 1s ease-in-out infinite;
               animation: line-spin-clockwise-fade-rotating 1s ease-in-out infinite;
               border-radius: 0;
               height: 10px;
               margin: -5px 2px 2px -1px;
               position: absolute;
               width: 2px
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -.875s;
               animation-delay: -.875s;
               left: 50%;
               top: 15%;
               transform: rotate(0deg)
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.75s;
               animation-delay: -.75s;
               left: 74.7487373415%;
               top: 25.2512626585%;
               transform: rotate(45deg)
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.625s;
               animation-delay: -.625s;
               left: 85%;
               top: 50%;
               transform: rotate(90deg)
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.5s;
               animation-delay: -.5s;
               left: 74.7487373415%;
               top: 74.7487373415%;
               transform: rotate(135deg)
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -.375s;
               animation-delay: -.375s;
               left: 50.0000000004%;
               top: 84.9999999974%;
               transform: rotate(180deg)
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -.25s;
               animation-delay: -.25s;
               left: 25.2512627193%;
               top: 74.7487369862%;
               transform: rotate(225deg)
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -.125s;
               animation-delay: -.125s;
               left: 15.0000039834%;
               top: 49.9999806189%;
               transform: rotate(270deg)
          }
          
          .la-line-spin-clockwise-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: 0s;
               animation-delay: 0s;
               left: 25.2513989292%;
               top: 25.2506949798%;
               transform: rotate(315deg)
          }
          
          .la-line-spin-clockwise-fade-rotating.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-line-spin-clockwise-fade-rotating.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: 0;
               margin-top: -2px;
               width: 1px
          }
          
          .la-line-spin-clockwise-fade-rotating.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-line-spin-clockwise-fade-rotating.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               margin-left: -2px;
               margin-top: -10px;
               width: 4px
          }
          
          .la-line-spin-clockwise-fade-rotating.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-line-spin-clockwise-fade-rotating.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               margin-left: -3px;
               margin-top: -15px;
               width: 6px
          }
          
          @-webkit-keyframes line-spin-clockwise-fade-rotating-rotate {
               to {
                    transform: rotate(-1turn)
               }
          }
          
          @keyframes line-spin-clockwise-fade-rotating-rotate {
               to {
                    transform: rotate(-1turn)
               }
          }
          
          @-webkit-keyframes line-spin-clockwise-fade-rotating {
               50% {
                    opacity: .2
               }
               to {
                    opacity: 1
               }
          }
          
          @keyframes line-spin-clockwise-fade-rotating {
               50% {
                    opacity: .2
               }
               to {
                    opacity: 1
               }
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38],
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-line-spin-clockwise-fade.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: line-spin-clockwise-fade 1s ease-in-out infinite;
               animation: line-spin-clockwise-fade 1s ease-in-out infinite;
               border-radius: 0;
               height: 10px;
               margin: -5px 2px 2px -1px;
               position: absolute;
               width: 2px
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -.875s;
               animation-delay: -.875s;
               left: 50%;
               top: 15%;
               transform: rotate(0deg)
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -.75s;
               animation-delay: -.75s;
               left: 74.7487373415%;
               top: 25.2512626585%;
               transform: rotate(45deg)
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -.625s;
               animation-delay: -.625s;
               left: 85%;
               top: 50%;
               transform: rotate(90deg)
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -.5s;
               animation-delay: -.5s;
               left: 74.7487373415%;
               top: 74.7487373415%;
               transform: rotate(135deg)
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -.375s;
               animation-delay: -.375s;
               left: 50.0000000004%;
               top: 84.9999999974%;
               transform: rotate(180deg)
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -.25s;
               animation-delay: -.25s;
               left: 25.2512627193%;
               top: 74.7487369862%;
               transform: rotate(225deg)
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -.125s;
               animation-delay: -.125s;
               left: 15.0000039834%;
               top: 49.9999806189%;
               transform: rotate(270deg)
          }
          
          .la-line-spin-clockwise-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: 0s;
               animation-delay: 0s;
               left: 25.2513989292%;
               top: 25.2506949798%;
               transform: rotate(315deg)
          }
          
          .la-line-spin-clockwise-fade.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-line-spin-clockwise-fade.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: 0;
               margin-top: -2px;
               width: 1px
          }
          
          .la-line-spin-clockwise-fade.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-line-spin-clockwise-fade.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               margin-left: -2px;
               margin-top: -10px;
               width: 4px
          }
          
          .la-line-spin-clockwise-fade.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-line-spin-clockwise-fade.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               margin-left: -3px;
               margin-top: -15px;
               width: 6px
          }
          
          @-webkit-keyframes line-spin-clockwise-fade {
               50% {
                    opacity: .2
               }
               to {
                    opacity: 1
               }
          }
          
          @keyframes line-spin-clockwise-fade {
               50% {
                    opacity: .2
               }
               to {
                    opacity: 1
               }
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38],
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-line-spin-fade-rotating.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38] {
               -webkit-animation: ball-spin-fade-rotating-rotate 6s linear infinite;
               animation: ball-spin-fade-rotating-rotate 6s linear infinite;
               height: 32px;
               width: 32px
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: line-spin-fade-rotating 1s ease-in-out infinite;
               animation: line-spin-fade-rotating 1s ease-in-out infinite;
               border-radius: 0;
               height: 10px;
               margin: -5px 2px 2px -1px;
               position: absolute;
               width: 2px
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -1.125s;
               animation-delay: -1.125s;
               left: 50%;
               top: 15%;
               transform: rotate(0deg)
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -1.25s;
               animation-delay: -1.25s;
               left: 74.7487373415%;
               top: 25.2512626585%;
               transform: rotate(45deg)
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -1.375s;
               animation-delay: -1.375s;
               left: 85%;
               top: 50%;
               transform: rotate(90deg)
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -1.5s;
               animation-delay: -1.5s;
               left: 74.7487373415%;
               top: 74.7487373415%;
               transform: rotate(135deg)
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -1.625s;
               animation-delay: -1.625s;
               left: 50.0000000004%;
               top: 84.9999999974%;
               transform: rotate(180deg)
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -1.75s;
               animation-delay: -1.75s;
               left: 25.2512627193%;
               top: 74.7487369862%;
               transform: rotate(225deg)
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -1.875s;
               animation-delay: -1.875s;
               left: 15.0000039834%;
               top: 49.9999806189%;
               transform: rotate(270deg)
          }
          
          .la-line-spin-fade-rotating[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: -2s;
               animation-delay: -2s;
               left: 25.2513989292%;
               top: 25.2506949798%;
               transform: rotate(315deg)
          }
          
          .la-line-spin-fade-rotating.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-line-spin-fade-rotating.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: 0;
               margin-top: -2px;
               width: 1px
          }
          
          .la-line-spin-fade-rotating.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-line-spin-fade-rotating.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               margin-left: -2px;
               margin-top: -10px;
               width: 4px
          }
          
          .la-line-spin-fade-rotating.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-line-spin-fade-rotating.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               margin-left: -3px;
               margin-top: -15px;
               width: 6px
          }
          
          @-webkit-keyframes ball-spin-fade-rotating-rotate {
               to {
                    transform: rotate(1turn)
               }
          }
          
          @keyframes ball-spin-fade-rotating-rotate {
               to {
                    transform: rotate(1turn)
               }
          }
          
          @-webkit-keyframes line-spin-fade-rotating {
               50% {
                    opacity: .2
               }
               to {
                    opacity: 1
               }
          }
          
          @keyframes line-spin-fade-rotating {
               50% {
                    opacity: .2
               }
               to {
                    opacity: 1
               }
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38],
          .la-line-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-line-spin-fade.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: line-spin-fade 1s ease-in-out infinite;
               animation: line-spin-fade 1s ease-in-out infinite;
               border-radius: 0;
               height: 10px;
               margin: -5px 2px 2px -1px;
               position: absolute;
               width: 2px
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation-delay: -1.125s;
               animation-delay: -1.125s;
               left: 50%;
               top: 15%;
               transform: rotate(0deg)
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-delay: -1.25s;
               animation-delay: -1.25s;
               left: 74.7487373415%;
               top: 25.2512626585%;
               transform: rotate(45deg)
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -1.375s;
               animation-delay: -1.375s;
               left: 85%;
               top: 50%;
               transform: rotate(90deg)
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -1.5s;
               animation-delay: -1.5s;
               left: 74.7487373415%;
               top: 74.7487373415%;
               transform: rotate(135deg)
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -1.625s;
               animation-delay: -1.625s;
               left: 50.0000000004%;
               top: 84.9999999974%;
               transform: rotate(180deg)
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -1.75s;
               animation-delay: -1.75s;
               left: 25.2512627193%;
               top: 74.7487369862%;
               transform: rotate(225deg)
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(7) {
               -webkit-animation-delay: -1.875s;
               animation-delay: -1.875s;
               left: 15.0000039834%;
               top: 49.9999806189%;
               transform: rotate(270deg)
          }
          
          .la-line-spin-fade[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(8) {
               -webkit-animation-delay: -2s;
               animation-delay: -2s;
               left: 25.2513989292%;
               top: 25.2506949798%;
               transform: rotate(315deg)
          }
          
          .la-line-spin-fade.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-line-spin-fade.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 4px;
               margin-left: 0;
               margin-top: -2px;
               width: 1px
          }
          
          .la-line-spin-fade.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-line-spin-fade.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 20px;
               margin-left: -2px;
               margin-top: -10px;
               width: 4px
          }
          
          .la-line-spin-fade.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-line-spin-fade.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 30px;
               margin-left: -3px;
               margin-top: -15px;
               width: 6px
          }
          
          @-webkit-keyframes line-spin-fade {
               50% {
                    opacity: .2
               }
               to {
                    opacity: 1
               }
          }
          
          @keyframes line-spin-fade {
               50% {
                    opacity: .2
               }
               to {
                    opacity: 1
               }
          }
          
          .la-pacman[_ngcontent-pjk-c38],
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-pacman[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-pacman.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-pacman[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child,
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation: pacman-rotate-half-up .5s 0s infinite;
               animation: pacman-rotate-half-up .5s 0s infinite;
               background: transparent;
               border-radius: 100%;
               border-right: solid transparent;
               border-style: solid;
               border-width: 16px;
               height: 0;
               position: absolute;
               width: 0
          }
          
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation-name: pacman-rotate-half-down;
               animation-name: pacman-rotate-half-down;
               top: 0
          }
          
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3),
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4),
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5),
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation: pacman-balls 2s linear 0s infinite;
               animation: pacman-balls 2s linear 0s infinite;
               border-radius: 100%;
               height: 8px;
               left: 200%;
               opacity: 0;
               position: absolute;
               top: 50%;
               width: 8px
          }
          
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3) {
               -webkit-animation-delay: -1.44s;
               animation-delay: -1.44s
          }
          
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4) {
               -webkit-animation-delay: -1.94s;
               animation-delay: -1.94s
          }
          
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5) {
               -webkit-animation-delay: -2.44s;
               animation-delay: -2.44s
          }
          
          .la-pacman[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               -webkit-animation-delay: -2.94s;
               animation-delay: -2.94s
          }
          
          .la-pacman.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-pacman.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child,
          .la-pacman.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               border-width: 8px;
               position: absolute
          }
          
          .la-pacman.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               top: 0
          }
          
          .la-pacman.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3),
          .la-pacman.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4),
          .la-pacman.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5),
          .la-pacman.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               height: 4px;
               width: 4px
          }
          
          .la-pacman.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-pacman.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child,
          .la-pacman.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               border-width: 32px;
               position: absolute
          }
          
          .la-pacman.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               top: 0
          }
          
          .la-pacman.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3),
          .la-pacman.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4),
          .la-pacman.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5),
          .la-pacman.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               height: 16px;
               width: 16px
          }
          
          .la-pacman.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-pacman.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child,
          .la-pacman.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               border-width: 48px;
               position: absolute
          }
          
          .la-pacman.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               top: 0
          }
          
          .la-pacman.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(3),
          .la-pacman.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(4),
          .la-pacman.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(5),
          .la-pacman.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(6) {
               height: 24px;
               width: 24px
          }
          
          @-webkit-keyframes pacman-rotate-half-up {
               0%,
               to {
                    transform: rotate(270deg)
               }
               50% {
                    transform: rotate(1turn)
               }
          }
          
          @keyframes pacman-rotate-half-up {
               0%,
               to {
                    transform: rotate(270deg)
               }
               50% {
                    transform: rotate(1turn)
               }
          }
          
          @-webkit-keyframes pacman-rotate-half-down {
               0%,
               to {
                    transform: rotate(90deg)
               }
               50% {
                    transform: rotate(0deg)
               }
          }
          
          @keyframes pacman-rotate-half-down {
               0%,
               to {
                    transform: rotate(90deg)
               }
               50% {
                    transform: rotate(0deg)
               }
          }
          
          @-webkit-keyframes pacman-balls {
               0% {
                    left: 200%;
                    opacity: 0;
                    transform: translateY(-50%)
               }
               5% {
                    opacity: .5
               }
               66% {
                    opacity: 1
               }
               67% {
                    opacity: 0
               }
               to {
                    left: 0;
                    transform: translateY(-50%)
               }
          }
          
          @keyframes pacman-balls {
               0% {
                    left: 200%;
                    opacity: 0;
                    transform: translateY(-50%)
               }
               5% {
                    opacity: .5
               }
               66% {
                    opacity: 1
               }
               67% {
                    opacity: 0
               }
               to {
                    left: 0;
                    transform: translateY(-50%)
               }
          }
          
          .la-square-jelly-box[_ngcontent-pjk-c38],
          .la-square-jelly-box[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-square-jelly-box[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-square-jelly-box.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-square-jelly-box[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-square-jelly-box[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-square-jelly-box[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child,
          .la-square-jelly-box[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               left: 0;
               position: absolute;
               width: 100%
          }
          
          .la-square-jelly-box[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:first-child {
               -webkit-animation: square-jelly-box-animate .6s linear -.1s infinite;
               animation: square-jelly-box-animate .6s linear -.1s infinite;
               border-radius: 10%;
               height: 100%;
               top: -25%;
               z-index: 1
          }
          
          .la-square-jelly-box[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:nth-child(2) {
               -webkit-animation: square-jelly-box-shadow .6s linear -.1s infinite;
               animation: square-jelly-box-shadow .6s linear -.1s infinite;
               background: #000;
               border-radius: 50%;
               bottom: -9%;
               height: 10%;
               opacity: .2
          }
          
          .la-square-jelly-box.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-square-jelly-box.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-square-jelly-box.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          @-webkit-keyframes square-jelly-box-animate {
               17% {
                    border-bottom-right-radius: 10%
               }
               25% {
                    transform: translateY(25%) rotate(22.5deg)
               }
               50% {
                    border-bottom-right-radius: 100%;
                    transform: translateY(50%) scaleY(.9) rotate(45deg)
               }
               75% {
                    transform: translateY(25%) rotate(67.5deg)
               }
               to {
                    transform: translateY(0) rotate(90deg)
               }
          }
          
          @keyframes square-jelly-box-animate {
               17% {
                    border-bottom-right-radius: 10%
               }
               25% {
                    transform: translateY(25%) rotate(22.5deg)
               }
               50% {
                    border-bottom-right-radius: 100%;
                    transform: translateY(50%) scaleY(.9) rotate(45deg)
               }
               75% {
                    transform: translateY(25%) rotate(67.5deg)
               }
               to {
                    transform: translateY(0) rotate(90deg)
               }
          }
          
          @-webkit-keyframes square-jelly-box-shadow {
               50% {
                    transform: scaleX(1.25)
               }
          }
          
          @keyframes square-jelly-box-shadow {
               50% {
                    transform: scaleX(1.25)
               }
          }
          
          .la-square-loader[_ngcontent-pjk-c38],
          .la-square-loader[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-square-loader[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-square-loader.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-square-loader[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-square-loader[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-square-loader[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: square-loader 2s ease infinite;
               animation: square-loader 2s ease infinite;
               background: transparent;
               border-radius: 0;
               border-width: 2px;
               height: 100%;
               width: 100%
          }
          
          .la-square-loader[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after {
               -webkit-animation: square-loader-inner 2s ease-in infinite;
               animation: square-loader-inner 2s ease-in infinite;
               background-color: currentColor;
               content: "";
               display: inline-block;
               vertical-align: top;
               width: 100%
          }
          
          .la-square-loader.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-square-loader.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 1px
          }
          
          .la-square-loader.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-square-loader.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 4px
          }
          
          .la-square-loader.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-square-loader.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 6px
          }
          
          @-webkit-keyframes square-loader {
               0% {
                    transform: rotate(0deg)
               }
               25% {
                    transform: rotate(180deg)
               }
               50% {
                    transform: rotate(180deg)
               }
               75% {
                    transform: rotate(1turn)
               }
               to {
                    transform: rotate(1turn)
               }
          }
          
          @keyframes square-loader {
               0% {
                    transform: rotate(0deg)
               }
               25% {
                    transform: rotate(180deg)
               }
               50% {
                    transform: rotate(180deg)
               }
               75% {
                    transform: rotate(1turn)
               }
               to {
                    transform: rotate(1turn)
               }
          }
          
          @-webkit-keyframes square-loader-inner {
               0% {
                    height: 0
               }
               25% {
                    height: 0
               }
               50% {
                    height: 100%
               }
               75% {
                    height: 100%
               }
               to {
                    height: 0
               }
          }
          
          @keyframes square-loader-inner {
               0% {
                    height: 0
               }
               25% {
                    height: 0
               }
               50% {
                    height: 100%
               }
               75% {
                    height: 100%
               }
               to {
                    height: 0
               }
          }
          
          .la-square-spin[_ngcontent-pjk-c38],
          .la-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-square-spin[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-square-spin.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-square-spin[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-square-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: square-spin 3s cubic-bezier(.09, .57, .49, .9) 0s infinite;
               animation: square-spin 3s cubic-bezier(.09, .57, .49, .9) 0s infinite;
               border-radius: 0;
               height: 100%;
               width: 100%
          }
          
          .la-square-spin.la-sm[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-square-spin.la-2x[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-square-spin.la-3x[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          @-webkit-keyframes square-spin {
               0% {
                    transform: perspective(100px) rotateX(0) rotateY(0)
               }
               25% {
                    transform: perspective(100px) rotateX(180deg) rotateY(0)
               }
               50% {
                    transform: perspective(100px) rotateX(180deg) rotateY(180deg)
               }
               75% {
                    transform: perspective(100px) rotateX(0) rotateY(180deg)
               }
               to {
                    transform: perspective(100px) rotateX(0) rotateY(1turn)
               }
          }
          
          @keyframes square-spin {
               0% {
                    transform: perspective(100px) rotateX(0) rotateY(0)
               }
               25% {
                    transform: perspective(100px) rotateX(180deg) rotateY(0)
               }
               50% {
                    transform: perspective(100px) rotateX(180deg) rotateY(180deg)
               }
               75% {
                    transform: perspective(100px) rotateX(0) rotateY(180deg)
               }
               to {
                    transform: perspective(100px) rotateX(0) rotateY(1turn)
               }
          }
          
          .la-timer[_ngcontent-pjk-c38],
          .la-timer[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-timer[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-timer.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-timer[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-timer[_ngcontent-pjk-c38],
          .la-timer[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 32px;
               width: 32px
          }
          
          .la-timer[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background: transparent;
               border-radius: 100%;
               border-width: 2px
          }
          
          .la-timer[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after,
          .la-timer[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:before {
               -webkit-animation: timer-loader 1.25s linear infinite;
               -webkit-animation-delay: -625ms;
               animation: timer-loader 1.25s linear infinite;
               animation-delay: -625ms;
               background: currentColor;
               border-radius: 2px;
               content: "";
               display: block;
               left: 14px;
               margin-left: -1px;
               margin-top: -1px;
               position: absolute;
               top: 14px;
               transform-origin: 1px 1px 0;
               width: 2px
          }
          
          .la-timer[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:before {
               height: 12px
          }
          
          .la-timer[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after {
               -webkit-animation-delay: -7.5s;
               -webkit-animation-duration: 15s;
               animation-delay: -7.5s;
               animation-duration: 15s;
               height: 8px
          }
          
          .la-timer.la-sm[_ngcontent-pjk-c38],
          .la-timer.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 16px;
               width: 16px
          }
          
          .la-timer.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 1px
          }
          
          .la-timer.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after,
          .la-timer.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:before {
               border-radius: 1px;
               left: 7px;
               margin-left: -.5px;
               margin-top: -.5px;
               top: 7px;
               transform-origin: .5px .5px 0;
               width: 1px
          }
          
          .la-timer.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:before {
               height: 6px
          }
          
          .la-timer.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after {
               height: 4px
          }
          
          .la-timer.la-2x[_ngcontent-pjk-c38],
          .la-timer.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 64px;
               width: 64px
          }
          
          .la-timer.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 4px
          }
          
          .la-timer.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after,
          .la-timer.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:before {
               border-radius: 4px;
               left: 28px;
               margin-left: -2px;
               margin-top: -2px;
               top: 28px;
               transform-origin: 2px 2px 0;
               width: 4px
          }
          
          .la-timer.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:before {
               height: 24px
          }
          
          .la-timer.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after {
               height: 16px
          }
          
          .la-timer.la-3x[_ngcontent-pjk-c38],
          .la-timer.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               height: 96px;
               width: 96px
          }
          
          .la-timer.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 6px
          }
          
          .la-timer.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after,
          .la-timer.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:before {
               border-radius: 6px;
               left: 42px;
               margin-left: -3px;
               margin-top: -3px;
               top: 42px;
               transform-origin: 3px 3px 0;
               width: 6px
          }
          
          .la-timer.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:before {
               height: 36px
          }
          
          .la-timer.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:after {
               height: 24px
          }
          
          @-webkit-keyframes timer-loader {
               0% {
                    transform: rotate(0deg)
               }
               to {
                    transform: rotate(1turn)
               }
          }
          
          @keyframes timer-loader {
               0% {
                    transform: rotate(0deg)
               }
               to {
                    transform: rotate(1turn)
               }
          }
          
          .la-triangle-skew-spin[_ngcontent-pjk-c38],
          .la-triangle-skew-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               box-sizing: border-box;
               position: relative
          }
          
          .la-triangle-skew-spin[_ngcontent-pjk-c38] {
               color: #fff;
               display: block;
               font-size: 0
          }
          
          .la-triangle-skew-spin.la-dark[_ngcontent-pjk-c38] {
               color: #333
          }
          
          .la-triangle-skew-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               background-color: currentColor;
               border: 0 solid;
               display: inline-block;
               float: none
          }
          
          .la-triangle-skew-spin[_ngcontent-pjk-c38] {
               height: 16px;
               width: 32px
          }
          
          .la-triangle-skew-spin[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               -webkit-animation: triangle-skew-spin 3s cubic-bezier(.09, .57, .49, .9) 0s infinite;
               animation: triangle-skew-spin 3s cubic-bezier(.09, .57, .49, .9) 0s infinite;
               background: transparent;
               border-color: currentcolor transparent;
               border-left: none;
               border-right: none;
               border-style: solid;
               border-width: 0 16px 16px;
               height: 0;
               width: 0
          }
          
          .la-triangle-skew-spin.la-sm[_ngcontent-pjk-c38] {
               height: 8px;
               width: 16px
          }
          
          .la-triangle-skew-spin.la-sm[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 0 8px 8px
          }
          
          .la-triangle-skew-spin.la-2x[_ngcontent-pjk-c38] {
               height: 32px;
               width: 64px
          }
          
          .la-triangle-skew-spin.la-2x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 0 32px 32px
          }
          
          .la-triangle-skew-spin.la-3x[_ngcontent-pjk-c38] {
               height: 48px;
               width: 96px
          }
          
          .la-triangle-skew-spin.la-3x[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38] {
               border-width: 0 48px 48px
          }
          
          @-webkit-keyframes triangle-skew-spin {
               0% {
                    transform: perspective(100px) rotateX(0) rotateY(0)
               }
               25% {
                    transform: perspective(100px) rotateX(180deg) rotateY(0)
               }
               50% {
                    transform: perspective(100px) rotateX(180deg) rotateY(180deg)
               }
               75% {
                    transform: perspective(100px) rotateX(0) rotateY(180deg)
               }
               to {
                    transform: perspective(100px) rotateX(0) rotateY(1turn)
               }
          }
          
          @keyframes triangle-skew-spin {
               0% {
                    transform: perspective(100px) rotateX(0) rotateY(0)
               }
               25% {
                    transform: perspective(100px) rotateX(180deg) rotateY(0)
               }
               50% {
                    transform: perspective(100px) rotateX(180deg) rotateY(180deg)
               }
               75% {
                    transform: perspective(100px) rotateX(0) rotateY(180deg)
               }

               to {
                    transform: perspective(100px) rotateX(0) rotateY(1turn)
               }
          }
          
          .overlay[_ngcontent-pjk-c38] {
               height: 100%;
               left: 0;
               position: fixed;
               top: 0;
               width: 100%
          }
          
          .overlay[_ngcontent-pjk-c38]> div[_ngcontent-pjk-c38]:not(.loading-text) {
               left: 50%;
               margin: 0;
               position: absolute;
               top: 50%;
               transform: translate(-50%, -50%)
          }
          
          .loading-text[_ngcontent-pjk-c38] {
               left: 50%;
               position: absolute;
               top: 60%;
               transform: translate(-50%, -60%)
          }
     </style>
     <style>
          .mat-button-toggle-standalone,
          .mat-button-toggle-group {
               position: relative;
               display: inline-flex;
               flex-direction: row;
               white-space: nowrap;
               overflow: hidden;
               border-radius: 2px;
               -webkit-tap-highlight-color: transparent
          }
          
          .cdk-high-contrast-active .mat-button-toggle-standalone,
          .cdk-high-contrast-active .mat-button-toggle-group {
               outline: solid 1px
          }
          
          .mat-button-toggle-standalone.mat-button-toggle-appearance-standard,
          .mat-button-toggle-group-appearance-standard {
               border-radius: 4px
          }
          
          .cdk-high-contrast-active .mat-button-toggle-standalone.mat-button-toggle-appearance-standard,
          .cdk-high-contrast-active .mat-button-toggle-group-appearance-standard {
               outline: 0
          }
          
          .mat-button-toggle-vertical {
               flex-direction: column
          }
          
          .mat-button-toggle-vertical .mat-button-toggle-label-content {
               display: block
          }
          
          .mat-button-toggle {
               white-space: nowrap;
               position: relative
          }
          
          .mat-button-toggle .mat-icon svg {
               vertical-align: top
          }
          
          .mat-button-toggle.cdk-keyboard-focused .mat-button-toggle-focus-overlay {
               opacity: 1
          }
          
          .cdk-high-contrast-active .mat-button-toggle.cdk-keyboard-focused .mat-button-toggle-focus-overlay {
               opacity: .5
          }
          
          .mat-button-toggle-appearance-standard:not(.mat-button-toggle-disabled):hover .mat-button-toggle-focus-overlay {
               opacity: .04
          }
          
          .mat-button-toggle-appearance-standard.cdk-keyboard-focused:not(.mat-button-toggle-disabled) .mat-button-toggle-focus-overlay {
               opacity: .12
          }
          
          .cdk-high-contrast-active .mat-button-toggle-appearance-standard.cdk-keyboard-focused:not(.mat-button-toggle-disabled) .mat-button-toggle-focus-overlay {
               opacity: .5
          }
          
          @media(hover: none) {
               .mat-button-toggle-appearance-standard:not(.mat-button-toggle-disabled):hover .mat-button-toggle-focus-overlay {
                    display: none
               }
          }
          
          .mat-button-toggle-label-content {
               -webkit-user-select: none;
               -moz-user-select: none;
               -ms-user-select: none;
               user-select: none;
               display: inline-block;
               line-height: 36px;
               padding: 0 16px;
               position: relative
          }
          
          .mat-button-toggle-appearance-standard .mat-button-toggle-label-content {
               padding: 0 12px
          }
          
          .mat-button-toggle-label-content>* {
               vertical-align: middle
          }
          
          .mat-button-toggle-focus-overlay {
               border-radius: inherit;
               pointer-events: none;
               opacity: 0;
               top: 0;
               left: 0;
               right: 0;
               bottom: 0;
               position: absolute
          }
          
          .mat-button-toggle-checked .mat-button-toggle-focus-overlay {
               border-bottom: solid 36px
          }
          
          .cdk-high-contrast-active .mat-button-toggle-checked .mat-button-toggle-focus-overlay {
               opacity: .5;
               height: 0
          }
          
          .cdk-high-contrast-active .mat-button-toggle-checked.mat-button-toggle-appearance-standard .mat-button-toggle-focus-overlay {
               border-bottom: solid 500px
          }
          
          .mat-button-toggle .mat-button-toggle-ripple {
               top: 0;
               left: 0;
               right: 0;
               bottom: 0;
               position: absolute;
               pointer-events: none
          }
          
          .mat-button-toggle-button {
               border: 0;
               background: none;
               color: inherit;
               padding: 0;
               margin: 0;
               font: inherit;
               outline: none;
               width: 100%;
               cursor: pointer
          }
          
          .mat-button-toggle-disabled .mat-button-toggle-button {
               cursor: default
          }
          
          .mat-button-toggle-button::-moz-focus-inner {
               border: 0
          }
     </style>
     <style>
          .mat-slide-toggle {
               display: inline-block;
               height: 24px;
               max-width: 100%;
               line-height: 24px;
               white-space: nowrap;
               outline: none;
               -webkit-tap-highlight-color: transparent
          }
          
          .mat-slide-toggle.mat-checked .mat-slide-toggle-thumb-container {
               transform: translate3d(16px, 0, 0)
          }
          
          [dir=rtl] .mat-slide-toggle.mat-checked .mat-slide-toggle-thumb-container {
               transform: translate3d(-16px, 0, 0)
          }
          
          .mat-slide-toggle.mat-disabled {
               opacity: .38
          }
          
          .mat-slide-toggle.mat-disabled .mat-slide-toggle-label,
          .mat-slide-toggle.mat-disabled .mat-slide-toggle-thumb-container {
               cursor: default
          }
          
          .mat-slide-toggle-label {
               display: flex;
               flex: 1;
               flex-direction: row;
               align-items: center;
               height: inherit;
               cursor: pointer
          }
          
          .mat-slide-toggle-content {
               white-space: nowrap;
               overflow: hidden;
               text-overflow: ellipsis
          }
          
          .mat-slide-toggle-label-before .mat-slide-toggle-label {
               order: 1
          }
          
          .mat-slide-toggle-label-before .mat-slide-toggle-bar {
               order: 2
          }
          
          [dir=rtl] .mat-slide-toggle-label-before .mat-slide-toggle-bar,
          .mat-slide-toggle-bar {
               margin-right: 8px;
               margin-left: 0
          }
          
          [dir=rtl] .mat-slide-toggle-bar,
          .mat-slide-toggle-label-before .mat-slide-toggle-bar {
               margin-left: 8px;
               margin-right: 0
          }
          
          .mat-slide-toggle-bar-no-side-margin {
               margin-left: 0;
               margin-right: 0
          }
          
          .mat-slide-toggle-thumb-container {
               position: absolute;
               z-index: 1;
               width: 20px;
               height: 20px;
               top: -3px;
               left: 0;
               transform: translate3d(0, 0, 0);
               transition: all 80ms linear;
               transition-property: transform
          }
          
          ._mat-animation-noopable .mat-slide-toggle-thumb-container {
               transition: none
          }
          
          [dir=rtl] .mat-slide-toggle-thumb-container {
               left: auto;
               right: 0
          }
          
          .mat-slide-toggle-thumb {
               height: 20px;
               width: 20px;
               border-radius: 50%
          }
          
          .mat-slide-toggle-bar {
               position: relative;
               width: 36px;
               height: 14px;
               flex-shrink: 0;
               border-radius: 8px
          }
          
          .mat-slide-toggle-input {
               bottom: 0;
               left: 10px
          }
          
          [dir=rtl] .mat-slide-toggle-input {
               left: auto;
               right: 10px
          }
          
          .mat-slide-toggle-bar,
          .mat-slide-toggle-thumb {
               transition: all 80ms linear;
               transition-property: background-color;
               transition-delay: 50ms
          }
          
          ._mat-animation-noopable .mat-slide-toggle-bar,
          ._mat-animation-noopable .mat-slide-toggle-thumb {
               transition: none
          }
          
          .mat-slide-toggle .mat-slide-toggle-ripple {
               position: absolute;
               top: calc(50% - 20px);
               left: calc(50% - 20px);
               height: 40px;
               width: 40px;
               z-index: 1;
               pointer-events: none
          }
          
          .mat-slide-toggle .mat-slide-toggle-ripple .mat-ripple-element:not(.mat-slide-toggle-persistent-ripple) {
               opacity: .12
          }
          
          .mat-slide-toggle-persistent-ripple {
               width: 100%;
               height: 100%;
               transform: none
          }
          
          .mat-slide-toggle-bar:hover .mat-slide-toggle-persistent-ripple {
               opacity: .04
          }
          
          .mat-slide-toggle:not(.mat-disabled).cdk-keyboard-focused .mat-slide-toggle-persistent-ripple {
               opacity: .12
          }
          
          .mat-slide-toggle-persistent-ripple,
          .mat-slide-toggle.mat-disabled .mat-slide-toggle-bar:hover .mat-slide-toggle-persistent-ripple {
               opacity: 0
          }
          
          @media(hover: none) {
               .mat-slide-toggle-bar:hover .mat-slide-toggle-persistent-ripple {
                    display: none
               }
          }
          
          .cdk-high-contrast-active .mat-slide-toggle-thumb,
          .cdk-high-contrast-active .mat-slide-toggle-bar {
               border: 1px solid
          }
          
          .cdk-high-contrast-active .mat-slide-toggle.cdk-keyboard-focused .mat-slide-toggle-bar {
               outline: 2px dotted;
               outline-offset: 5px
          }
     </style>
     <style>
          .mat-button .mat-button-focus-overlay,
          .mat-icon-button .mat-button-focus-overlay {
               opacity: 0
          }
          
          .mat-button:hover:not(.mat-button-disabled) .mat-button-focus-overlay,
          .mat-stroked-button:hover:not(.mat-button-disabled) .mat-button-focus-overlay {
               opacity: .04
          }
          
          @media(hover: none) {
               .mat-button:hover:not(.mat-button-disabled) .mat-button-focus-overlay,
               .mat-stroked-button:hover:not(.mat-button-disabled) .mat-button-focus-overlay {
                    opacity: 0
               }
          }
          
          .mat-button,
          .mat-icon-button,
          .mat-stroked-button,
          .mat-flat-button {
               box-sizing: border-box;
               position: relative;
               -webkit-user-select: none;
               -moz-user-select: none;
               -ms-user-select: none;
               user-select: none;
               cursor: pointer;
               outline: none;
               border: none;
               -webkit-tap-highlight-color: transparent;
               display: inline-block;
               white-space: nowrap;
               text-decoration: none;
               vertical-align: baseline;
               text-align: center;
               margin: 0;
               min-width: 64px;
               line-height: 36px;
               padding: 0 16px;
               border-radius: 4px;
               overflow: visible
          }
          
          .mat-button::-moz-focus-inner,
          .mat-icon-button::-moz-focus-inner,
          .mat-stroked-button::-moz-focus-inner,
          .mat-flat-button::-moz-focus-inner {
               border: 0
          }
          
          .mat-button.mat-button-disabled,
          .mat-icon-button.mat-button-disabled,
          .mat-stroked-button.mat-button-disabled,
          .mat-flat-button.mat-button-disabled {
               cursor: default
          }
          
          .mat-button.cdk-keyboard-focused .mat-button-focus-overlay,
          .mat-button.cdk-program-focused .mat-button-focus-overlay,
          .mat-icon-button.cdk-keyboard-focused .mat-button-focus-overlay,
          .mat-icon-button.cdk-program-focused .mat-button-focus-overlay,
          .mat-stroked-button.cdk-keyboard-focused .mat-button-focus-overlay,
          .mat-stroked-button.cdk-program-focused .mat-button-focus-overlay,
          .mat-flat-button.cdk-keyboard-focused .mat-button-focus-overlay,
          .mat-flat-button.cdk-program-focused .mat-button-focus-overlay {
               opacity: .12
          }
          
          .mat-button::-moz-focus-inner,
          .mat-icon-button::-moz-focus-inner,
          .mat-stroked-button::-moz-focus-inner,
          .mat-flat-button::-moz-focus-inner {
               border: 0
          }
          
          .mat-raised-button {
               box-sizing: border-box;
               position: relative;
               -webkit-user-select: none;
               -moz-user-select: none;
               -ms-user-select: none;
               user-select: none;
               cursor: pointer;
               outline: none;
               border: none;
               -webkit-tap-highlight-color: transparent;
               display: inline-block;
               white-space: nowrap;
               text-decoration: none;
               vertical-align: baseline;
               text-align: center;
               margin: 0;
               min-width: 64px;
               line-height: 36px;
               padding: 0 16px;
               border-radius: 4px;
               overflow: visible;
               transform: translate3d(0, 0, 0);
               transition: background 400ms cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1)
          }
          
          .mat-raised-button::-moz-focus-inner {
               border: 0
          }
          
          .mat-raised-button.mat-button-disabled {
               cursor: default
          }
          
          .mat-raised-button.cdk-keyboard-focused .mat-button-focus-overlay,
          .mat-raised-button.cdk-program-focused .mat-button-focus-overlay {
               opacity: .12
          }
          
          .mat-raised-button::-moz-focus-inner {
               border: 0
          }
          
          ._mat-animation-noopable.mat-raised-button {
               transition: none;
               animation: none
          }
          
          .mat-stroked-button {
               border: 1px solid currentColor;
               padding: 0 15px;
               line-height: 34px
          }
          
          .mat-stroked-button .mat-button-ripple.mat-ripple,
          .mat-stroked-button .mat-button-focus-overlay {
               top: -1px;
               left: -1px;
               right: -1px;
               bottom: -1px
          }
          
          .mat-fab {
               box-sizing: border-box;
               position: relative;
               -webkit-user-select: none;
               -moz-user-select: none;
               -ms-user-select: none;
               user-select: none;
               cursor: pointer;
               outline: none;
               border: none;
               -webkit-tap-highlight-color: transparent;
               display: inline-block;
               white-space: nowrap;
               text-decoration: none;
               vertical-align: baseline;
               text-align: center;
               margin: 0;
               min-width: 64px;
               line-height: 36px;
               padding: 0 16px;
               border-radius: 4px;
               overflow: visible;
               transform: translate3d(0, 0, 0);
               transition: background 400ms cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1);
               min-width: 0;
               border-radius: 50%;
               width: 56px;
               height: 56px;
               padding: 0;
               flex-shrink: 0
          }
          
          .mat-fab::-moz-focus-inner {
               border: 0
          }
          
          .mat-fab.mat-button-disabled {
               cursor: default
          }
          
          .mat-fab.cdk-keyboard-focused .mat-button-focus-overlay,
          .mat-fab.cdk-program-focused .mat-button-focus-overlay {
               opacity: .12
          }
          
          .mat-fab::-moz-focus-inner {
               border: 0
          }
          
          ._mat-animation-noopable.mat-fab {
               transition: none;
               animation: none
          }
          
          .mat-fab .mat-button-wrapper {
               padding: 16px 0;
               display: inline-block;
               line-height: 24px
          }
          
          .mat-mini-fab {
               box-sizing: border-box;
               position: relative;
               -webkit-user-select: none;
               -moz-user-select: none;
               -ms-user-select: none;
               user-select: none;
               cursor: pointer;
               outline: none;
               border: none;
               -webkit-tap-highlight-color: transparent;
               display: inline-block;
               white-space: nowrap;
               text-decoration: none;
               vertical-align: baseline;
               text-align: center;
               margin: 0;
               min-width: 64px;
               line-height: 36px;
               padding: 0 16px;
               border-radius: 4px;
               overflow: visible;
               transform: translate3d(0, 0, 0);
               transition: background 400ms cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 280ms cubic-bezier(0.4, 0, 0.2, 1);
               min-width: 0;
               border-radius: 50%;
               width: 40px;
               height: 40px;
               padding: 0;
               flex-shrink: 0
          }
          
          .mat-mini-fab::-moz-focus-inner {
               border: 0
          }
          
          .mat-mini-fab.mat-button-disabled {
               cursor: default
          }
          
          .mat-mini-fab.cdk-keyboard-focused .mat-button-focus-overlay,
          .mat-mini-fab.cdk-program-focused .mat-button-focus-overlay {
               opacity: .12
          }
          
          .mat-mini-fab::-moz-focus-inner {
               border: 0
          }
          
          ._mat-animation-noopable.mat-mini-fab {
               transition: none;
               animation: none
          }
          
          .mat-mini-fab .mat-button-wrapper {
               padding: 8px 0;
               display: inline-block;
               line-height: 24px
          }
          
          .mat-icon-button {
               padding: 0;
               min-width: 0;
               width: 40px;
               height: 40px;
               flex-shrink: 0;
               line-height: 40px;
               border-radius: 50%
          }
          
          .mat-icon-button i,
          .mat-icon-button .mat-icon {
               line-height: 24px
          }
          
          .mat-button-ripple.mat-ripple,
          .mat-button-focus-overlay {
               top: 0;
               left: 0;
               right: 0;
               bottom: 0;
               position: absolute;
               pointer-events: none;
               border-radius: inherit
          }
          
          .mat-button-ripple.mat-ripple:not(:empty) {
               transform: translateZ(0)
          }
          
          .mat-button-focus-overlay {
               opacity: 0;
               transition: opacity 200ms cubic-bezier(0.35, 0, 0.25, 1), background-color 200ms cubic-bezier(0.35, 0, 0.25, 1)
          }
          
          ._mat-animation-noopable .mat-button-focus-overlay {
               transition: none
          }
          
          .cdk-high-contrast-active .mat-button-focus-overlay {
               background-color: #fff
          }
          
          .cdk-high-contrast-black-on-white .mat-button-focus-overlay {
               background-color: #000
          }
          
          .mat-button-ripple-round {
               border-radius: 50%;
               z-index: 1
          }
          
          .mat-button .mat-button-wrapper>*,
          .mat-flat-button .mat-button-wrapper>*,
          .mat-stroked-button .mat-button-wrapper>*,
          .mat-raised-button .mat-button-wrapper>*,
          .mat-icon-button .mat-button-wrapper>*,
          .mat-fab .mat-button-wrapper>*,
          .mat-mini-fab .mat-button-wrapper>* {
               vertical-align: middle
          }
          
          .mat-form-field:not(.mat-form-field-appearance-legacy) .mat-form-field-prefix .mat-icon-button,
          .mat-form-field:not(.mat-form-field-appearance-legacy) .mat-form-field-suffix .mat-icon-button {
               display: block;
               font-size: inherit;
               width: 2.5em;
               height: 2.5em
          }
          
          .cdk-high-contrast-active .mat-button,
          .cdk-high-contrast-active .mat-flat-button,
          .cdk-high-contrast-active .mat-raised-button,
          .cdk-high-contrast-active .mat-icon-button,
          .cdk-high-contrast-active .mat-fab,
          .cdk-high-contrast-active .mat-mini-fab {
               outline: solid 1px
          }
     </style>
     <style>
          .mat-icon {
               background-repeat: no-repeat;
               display: inline-block;
               fill: currentColor;
               height: 24px;
               width: 24px
          }
          
          .mat-icon.mat-icon-inline {
               font-size: inherit;
               height: inherit;
               line-height: inherit;
               width: inherit
          }
          
          [dir=rtl] .mat-icon-rtl-mirror {
               transform: scale(-1, 1)
          }
          
          .mat-form-field:not(.mat-form-field-appearance-legacy) .mat-form-field-prefix .mat-icon,
          .mat-form-field:not(.mat-form-field-appearance-legacy) .mat-form-field-suffix .mat-icon {
               display: block
          }
          
          .mat-form-field:not(.mat-form-field-appearance-legacy) .mat-form-field-prefix .mat-icon-button .mat-icon,
          .mat-form-field:not(.mat-form-field-appearance-legacy) .mat-form-field-suffix .mat-icon-button .mat-icon {
               margin: auto
          }
     </style>
     <style type="text/css">
          .jqstooltip {
               position: absolute;
               left: 0px;
               top: 0px;
               visibility: hidden;
               background: rgb(0, 0, 0) transparent;
               background-color: rgba(0, 0, 0, 0.6);
               filter: progid: DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
               -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
               color: white;
               font: 10px arial, san serif;
               text-align: left;
               white-space: nowrap;
               padding: 5px;
               border: 1px solid white;
               box-sizing: content-box;
               z-index: 10000;
          }
          
          .jqsfield {
               color: white;
               font: 10px arial, san serif;
               text-align: left;
          }
     </style>
     <style>
          .mat-form-field {
               display: inline-block;
               position: relative;
               text-align: left
          }
          
          [dir=rtl] .mat-form-field {
               text-align: right
          }
          
          .mat-form-field-wrapper {
               position: relative
          }
          
          .mat-form-field-flex {
               display: inline-flex;
               align-items: baseline;
               box-sizing: border-box;
               width: 100%
          }
          
          .mat-form-field-prefix,
          .mat-form-field-suffix {
               white-space: nowrap;
               flex: none;
               position: relative
          }
          
          .mat-form-field-infix {
               display: block;
               position: relative;
               flex: auto;
               min-width: 0;
               width: 180px
          }
          
          .cdk-high-contrast-active .mat-form-field-infix {
               border-image: linear-gradient(transparent, transparent)
          }
          
          .mat-form-field-label-wrapper {
               position: absolute;
               left: 0;
               box-sizing: content-box;
               width: 100%;
               height: 100%;
               overflow: hidden;
               pointer-events: none
          }
          
          [dir=rtl] .mat-form-field-label-wrapper {
               left: auto;
               right: 0
          }
          
          .mat-form-field-label {
               position: absolute;
               left: 0;
               font: inherit;
               pointer-events: none;
               width: 100%;
               white-space: nowrap;
               text-overflow: ellipsis;
               overflow: hidden;
               transform-origin: 0 0;
               transition: transform 400ms cubic-bezier(0.25, 0.8, 0.25, 1), color 400ms cubic-bezier(0.25, 0.8, 0.25, 1), width 400ms cubic-bezier(0.25, 0.8, 0.25, 1);
               display: none
          }
          
          [dir=rtl] .mat-form-field-label {
               transform-origin: 100% 0;
               left: auto;
               right: 0
          }
          
          .mat-form-field-empty.mat-form-field-label,
          .mat-form-field-can-float.mat-form-field-should-float .mat-form-field-label {
               display: block
          }
          
          .mat-form-field-autofill-control:-webkit-autofill+.mat-form-field-label-wrapper .mat-form-field-label {
               display: none
          }
          
          .mat-form-field-can-float .mat-form-field-autofill-control:-webkit-autofill+.mat-form-field-label-wrapper .mat-form-field-label {
               display: block;
               transition: none
          }
          
          .mat-input-server:focus+.mat-form-field-label-wrapper .mat-form-field-label,
          .mat-input-server[placeholder]:not(:placeholder-shown)+.mat-form-field-label-wrapper .mat-form-field-label {
               display: none
          }
          
          .mat-form-field-can-float .mat-input-server:focus+.mat-form-field-label-wrapper .mat-form-field-label,
          .mat-form-field-can-float .mat-input-server[placeholder]:not(:placeholder-shown)+.mat-form-field-label-wrapper .mat-form-field-label {
               display: block
          }
          
          .mat-form-field-label:not(.mat-form-field-empty) {
               transition: none
          }
          
          .mat-form-field-underline {
               position: absolute;
               width: 100%;
               pointer-events: none;
               transform: scale3d(1, 1.0001, 1)
          }
          
          .mat-form-field-ripple {
               position: absolute;
               left: 0;
               width: 100%;
               transform-origin: 50%;
               transform: scaleX(0.5);
               opacity: 0;
               transition: background-color 300ms cubic-bezier(0.55, 0, 0.55, 0.2)
          }
          
          .mat-form-field.mat-focused .mat-form-field-ripple,
          .mat-form-field.mat-form-field-invalid .mat-form-field-ripple {
               opacity: 1;
               transform: scaleX(1);
               transition: transform 300ms cubic-bezier(0.25, 0.8, 0.25, 1), opacity 100ms cubic-bezier(0.25, 0.8, 0.25, 1), background-color 300ms cubic-bezier(0.25, 0.8, 0.25, 1)
          }
          
          .mat-form-field-subscript-wrapper {
               position: absolute;
               box-sizing: border-box;
               width: 100%;
               overflow: hidden
          }
          
          .mat-form-field-subscript-wrapper .mat-icon,
          .mat-form-field-label-wrapper .mat-icon {
               width: 1em;
               height: 1em;
               font-size: inherit;
               vertical-align: baseline
          }
          
          .mat-form-field-hint-wrapper {
               display: flex
          }
          
          .mat-form-field-hint-spacer {
               flex: 1 0 1em
          }
          
          .mat-error {
               display: block
          }
          
          .mat-form-field-control-wrapper {
               position: relative
          }
          
          .mat-form-field._mat-animation-noopable .mat-form-field-label,
          .mat-form-field._mat-animation-noopable .mat-form-field-ripple {
               transition: none
          }
     </style>
     <style>
          .mat-form-field-appearance-fill .mat-form-field-flex {
               border-radius: 4px 4px 0 0;
               padding: .75em .75em 0 .75em
          }
          
          .cdk-high-contrast-active .mat-form-field-appearance-fill .mat-form-field-flex {
               outline: solid 1px
          }
          
          .mat-form-field-appearance-fill .mat-form-field-underline::before {
               content: "";
               display: block;
               position: absolute;
               bottom: 0;
               height: 1px;
               width: 100%
          }
          
          .mat-form-field-appearance-fill .mat-form-field-ripple {
               bottom: 0;
               height: 2px
          }
          
          .cdk-high-contrast-active .mat-form-field-appearance-fill .mat-form-field-ripple {
               height: 0;
               border-top: solid 2px
          }
          
          .mat-form-field-appearance-fill:not(.mat-form-field-disabled) .mat-form-field-flex:hover~.mat-form-field-underline .mat-form-field-ripple {
               opacity: 1;
               transform: none;
               transition: opacity 600ms cubic-bezier(0.25, 0.8, 0.25, 1)
          }
          
          .mat-form-field-appearance-fill._mat-animation-noopable:not(.mat-form-field-disabled) .mat-form-field-flex:hover~.mat-form-field-underline .mat-form-field-ripple {
               transition: none
          }
          
          .mat-form-field-appearance-fill .mat-form-field-subscript-wrapper {
               padding: 0 1em
          }
     </style>
     <style>
          .mat-input-element {
               font: inherit;
               background: transparent;
               color: currentColor;
               border: none;
               outline: none;
               padding: 0;
               margin: 0;
               width: 100%;
               max-width: 100%;
               vertical-align: bottom;
               text-align: inherit
          }
          
          .mat-input-element:-moz-ui-invalid {
               box-shadow: none
          }
          
          .mat-input-element::-ms-clear,
          .mat-input-element::-ms-reveal {
               display: none
          }
          
          .mat-input-element,
          .mat-input-element::-webkit-search-cancel-button,
          .mat-input-element::-webkit-search-decoration,
          .mat-input-element::-webkit-search-results-button,
          .mat-input-element::-webkit-search-results-decoration {
               -webkit-appearance: none
          }
          
          .mat-input-element::-webkit-contacts-auto-fill-button,
          .mat-input-element::-webkit-caps-lock-indicator,
          .mat-input-element::-webkit-credentials-auto-fill-button {
               visibility: hidden
          }
          
          .mat-input-element[type=date],
          .mat-input-element[type=datetime],
          .mat-input-element[type=datetime-local],
          .mat-input-element[type=month],
          .mat-input-element[type=week],
          .mat-input-element[type=time] {
               line-height: 1
          }
          
          .mat-input-element[type=date]::after,
          .mat-input-element[type=datetime]::after,
          .mat-input-element[type=datetime-local]::after,
          .mat-input-element[type=month]::after,
          .mat-input-element[type=week]::after,
          .mat-input-element[type=time]::after {
               content: " ";
               white-space: pre;
               width: 1px
          }
          
          .mat-input-element::-webkit-inner-spin-button,
          .mat-input-element::-webkit-calendar-picker-indicator,
          .mat-input-element::-webkit-clear-button {
               font-size: .75em
          }
          
          .mat-input-element::placeholder {
               -webkit-user-select: none;
               -moz-user-select: none;
               -ms-user-select: none;
               user-select: none;
               transition: color 400ms 133.3333333333ms cubic-bezier(0.25, 0.8, 0.25, 1)
          }
          
          .mat-input-element::placeholder:-ms-input-placeholder {
               -ms-user-select: text
          }
          
          .mat-input-element::-moz-placeholder {
               -webkit-user-select: none;
               -moz-user-select: none;
               -ms-user-select: none;
               user-select: none;
               transition: color 400ms 133.3333333333ms cubic-bezier(0.25, 0.8, 0.25, 1)
          }
          
          .mat-input-element::-moz-placeholder:-ms-input-placeholder {
               -ms-user-select: text
          }
          
          .mat-input-element::-webkit-input-placeholder {
               -webkit-user-select: none;
               -moz-user-select: none;
               -ms-user-select: none;
               user-select: none;
               transition: color 400ms 133.3333333333ms cubic-bezier(0.25, 0.8, 0.25, 1)
          }
          
          .mat-input-element::-webkit-input-placeholder:-ms-input-placeholder {
               -ms-user-select: text
          }
          
          .mat-input-element:-ms-input-placeholder {
               -webkit-user-select: none;
               -moz-user-select: none;
               -ms-user-select: none;
               user-select: none;
               transition: color 400ms 133.3333333333ms cubic-bezier(0.25, 0.8, 0.25, 1)
          }
          
          .mat-input-element:-ms-input-placeholder:-ms-input-placeholder {
               -ms-user-select: text
          }
          
          .mat-form-field-hide-placeholder .mat-input-element::placeholder {
               color: transparent !important;
               -webkit-text-fill-color: transparent;
               transition: none
          }
          
          .mat-form-field-hide-placeholder .mat-input-element::-moz-placeholder {
               color: transparent !important;
               -webkit-text-fill-color: transparent;
               transition: none
          }
          
          .mat-form-field-hide-placeholder .mat-input-element::-webkit-input-placeholder {
               color: transparent !important;
               -webkit-text-fill-color: transparent;
               transition: none
          }
          
          .mat-form-field-hide-placeholder .mat-input-element:-ms-input-placeholder {
               color: transparent !important;
               -webkit-text-fill-color: transparent;
               transition: none
          }
          
          textarea.mat-input-element {
               resize: vertical;
               overflow: auto
          }
          
          textarea.mat-input-element.cdk-textarea-autosize {
               resize: none
          }
          
          textarea.mat-input-element {
               padding: 2px 0;
               margin: -2px 0
          }
          
          select.mat-input-element {
               -moz-appearance: none;
               -webkit-appearance: none;
               position: relative;
               background-color: transparent;
               display: inline-flex;
               box-sizing: border-box;
               padding-top: 1em;
               top: -1em;
               margin-bottom: -1em
          }
          
          select.mat-input-element::-ms-expand {
               display: none
          }
          
          select.mat-input-element::-moz-focus-inner {
               border: 0
          }
          
          select.mat-input-element:not(:disabled) {
               cursor: pointer
          }
          
          select.mat-input-element::-ms-value {
               color: inherit;
               background: none
          }
          
          .mat-focused .cdk-high-contrast-active select.mat-input-element::-ms-value {
               color: inherit
          }
          
          .mat-form-field-type-mat-native-select .mat-form-field-infix::after {
               content: "";
               width: 0;
               height: 0;
               border-left: 5px solid transparent;
               border-right: 5px solid transparent;
               border-top: 5px solid;
               position: absolute;
               top: 50%;
               right: 0;
               margin-top: -2.5px;
               pointer-events: none
          }
          
          [dir=rtl] .mat-form-field-type-mat-native-select .mat-form-field-infix::after {
               right: auto;
               left: 0
          }
          
          .mat-form-field-type-mat-native-select .mat-input-element {
               padding-right: 15px
          }
          
          [dir=rtl] .mat-form-field-type-mat-native-select .mat-input-element {
               padding-right: 0;
               padding-left: 15px
          }
          
          .mat-form-field-type-mat-native-select .mat-form-field-label-wrapper {
               max-width: calc(100% - 10px)
          }
          
          .mat-form-field-type-mat-native-select.mat-form-field-appearance-outline .mat-form-field-infix::after {
               margin-top: -5px
          }
          
          .mat-form-field-type-mat-native-select.mat-form-field-appearance-fill .mat-form-field-infix::after {
               margin-top: -10px
          }
     </style>
     <style>
          .mat-form-field-appearance-legacy .mat-form-field-label {
               transform: perspective(100px);
               -ms-transform: none
          }
          
          .mat-form-field-appearance-legacy .mat-form-field-prefix .mat-icon,
          .mat-form-field-appearance-legacy .mat-form-field-suffix .mat-icon {
               width: 1em
          }
          
          .mat-form-field-appearance-legacy .mat-form-field-prefix .mat-icon-button,
          .mat-form-field-appearance-legacy .mat-form-field-suffix .mat-icon-button {
               font: inherit;
               vertical-align: baseline
          }
          
          .mat-form-field-appearance-legacy .mat-form-field-prefix .mat-icon-button .mat-icon,
          .mat-form-field-appearance-legacy .mat-form-field-suffix .mat-icon-button .mat-icon {
               font-size: inherit
          }
          
          .mat-form-field-appearance-legacy .mat-form-field-underline {
               height: 1px
          }
          
          .cdk-high-contrast-active .mat-form-field-appearance-legacy .mat-form-field-underline {
               height: 0;
               border-top: solid 1px
          }
          
          .mat-form-field-appearance-legacy .mat-form-field-ripple {
               top: 0;
               height: 2px;
               overflow: hidden
          }
          
          .cdk-high-contrast-active .mat-form-field-appearance-legacy .mat-form-field-ripple {
               height: 0;
               border-top: solid 2px
          }
          
          .mat-form-field-appearance-legacy.mat-form-field-disabled .mat-form-field-underline {
               background-position: 0;
               background-color: transparent
          }
          
          .cdk-high-contrast-active .mat-form-field-appearance-legacy.mat-form-field-disabled .mat-form-field-underline {
               border-top-style: dotted;
               border-top-width: 2px
          }
          
          .mat-form-field-appearance-legacy.mat-form-field-invalid:not(.mat-focused) .mat-form-field-ripple {
               height: 1px
          }
     </style>
     <style>
          .mat-form-field-appearance-outline .mat-form-field-wrapper {
               margin: .25em 0
          }
          
          .mat-form-field-appearance-outline .mat-form-field-flex {
               padding: 0 .75em 0 .75em;
               margin-top: -0.25em;
               position: relative
          }
          
          .mat-form-field-appearance-outline .mat-form-field-prefix,
          .mat-form-field-appearance-outline .mat-form-field-suffix {
               top: .25em
          }
          
          .mat-form-field-appearance-outline .mat-form-field-outline {
               display: flex;
               position: absolute;
               top: .25em;
               left: 0;
               right: 0;
               bottom: 0;
               pointer-events: none
          }
          
          .mat-form-field-appearance-outline .mat-form-field-outline-start,
          .mat-form-field-appearance-outline .mat-form-field-outline-end {
               border: 1px solid currentColor;
               min-width: 5px
          }
          
          .mat-form-field-appearance-outline .mat-form-field-outline-start {
               border-radius: 5px 0 0 5px;
               border-right-style: none
          }
          
          [dir=rtl] .mat-form-field-appearance-outline .mat-form-field-outline-start {
               border-right-style: solid;
               border-left-style: none;
               border-radius: 0 5px 5px 0
          }
          
          .mat-form-field-appearance-outline .mat-form-field-outline-end {
               border-radius: 0 5px 5px 0;
               border-left-style: none;
               flex-grow: 1
          }
          
          [dir=rtl] .mat-form-field-appearance-outline .mat-form-field-outline-end {
               border-left-style: solid;
               border-right-style: none;
               border-radius: 5px 0 0 5px
          }
          
          .mat-form-field-appearance-outline .mat-form-field-outline-gap {
               border-radius: .000001px;
               border: 1px solid currentColor;
               border-left-style: none;
               border-right-style: none
          }
          
          .mat-form-field-appearance-outline.mat-form-field-can-float.mat-form-field-should-float .mat-form-field-outline-gap {
               border-top-color: transparent
          }
          
          .mat-form-field-appearance-outline .mat-form-field-outline-thick {
               opacity: 0
          }
          
          .mat-form-field-appearance-outline .mat-form-field-outline-thick .mat-form-field-outline-start,
          .mat-form-field-appearance-outline .mat-form-field-outline-thick .mat-form-field-outline-end,
          .mat-form-field-appearance-outline .mat-form-field-outline-thick .mat-form-field-outline-gap {
               border-width: 2px
          }
          
          .mat-form-field-appearance-outline.mat-focused .mat-form-field-outline,
          .mat-form-field-appearance-outline.mat-form-field-invalid .mat-form-field-outline {
               opacity: 0;
               transition: opacity 100ms cubic-bezier(0.25, 0.8, 0.25, 1)
          }
          
          .mat-form-field-appearance-outline.mat-focused .mat-form-field-outline-thick,
          .mat-form-field-appearance-outline.mat-form-field-invalid .mat-form-field-outline-thick {
               opacity: 1
          }
          
          .mat-form-field-appearance-outline:not(.mat-form-field-disabled) .mat-form-field-flex:hover .mat-form-field-outline {
               opacity: 0;
               transition: opacity 600ms cubic-bezier(0.25, 0.8, 0.25, 1)
          }
          
          .mat-form-field-appearance-outline:not(.mat-form-field-disabled) .mat-form-field-flex:hover .mat-form-field-outline-thick {
               opacity: 1
          }
          
          .mat-form-field-appearance-outline .mat-form-field-subscript-wrapper {
               padding: 0 1em
          }
          
          .mat-form-field-appearance-outline._mat-animation-noopable:not(.mat-form-field-disabled) .mat-form-field-flex:hover~.mat-form-field-outline,
          .mat-form-field-appearance-outline._mat-animation-noopable .mat-form-field-outline,
          .mat-form-field-appearance-outline._mat-animation-noopable .mat-form-field-outline-start,
          .mat-form-field-appearance-outline._mat-animation-noopable .mat-form-field-outline-end,
          .mat-form-field-appearance-outline._mat-animation-noopable .mat-form-field-outline-gap {
               transition: none
          }
     </style>
     <style>
          .mat-form-field-appearance-standard .mat-form-field-flex {
               padding-top: .75em
          }
          
          .mat-form-field-appearance-standard .mat-form-field-underline {
               height: 1px
          }
          
          .cdk-high-contrast-active .mat-form-field-appearance-standard .mat-form-field-underline {
               height: 0;
               border-top: solid 1px
          }
          
          .mat-form-field-appearance-standard .mat-form-field-ripple {
               bottom: 0;
               height: 2px
          }
          
          .cdk-high-contrast-active .mat-form-field-appearance-standard .mat-form-field-ripple {
               height: 0;
               border-top: 2px
          }
          
          .mat-form-field-appearance-standard.mat-form-field-disabled .mat-form-field-underline {
               background-position: 0;
               background-color: transparent
          }
          
          .cdk-high-contrast-active .mat-form-field-appearance-standard.mat-form-field-disabled .mat-form-field-underline {
               border-top-style: dotted;
               border-top-width: 2px
          }
          
          .mat-form-field-appearance-standard:not(.mat-form-field-disabled) .mat-form-field-flex:hover~.mat-form-field-underline .mat-form-field-ripple {
               opacity: 1;
               transform: none;
               transition: opacity 600ms cubic-bezier(0.25, 0.8, 0.25, 1)
          }
          
          .mat-form-field-appearance-standard._mat-animation-noopable:not(.mat-form-field-disabled) .mat-form-field-flex:hover~.mat-form-field-underline .mat-form-field-ripple {
               transition: none
          }
     </style>
     <style type="text/css">
          /* Chart.js */
          /*
 * DOM element rendering detection
 * https://davidwalsh.name/detect-node-insertion
 */
          
          @keyframes chartjs-render-animation {
               from {
                    opacity: 0.99;
               }
               to {
                    opacity: 1;
               }
          }
          
          .chartjs-render-monitor {
               animation: chartjs-render-animation 0.001s;
          }
          /*
 * DOM element resizing detection
 * https://github.com/marcj/css-element-queries
 */
          
          .chartjs-size-monitor,
          .chartjs-size-monitor-expand,
          .chartjs-size-monitor-shrink {
               position: absolute;
               direction: ltr;
               left: 0;
               top: 0;
               right: 0;
               bottom: 0;
               overflow: hidden;
               pointer-events: none;
               visibility: hidden;
               z-index: -1;
          }
          
          .chartjs-size-monitor-expand> div {
               position: absolute;
               width: 1000000px;
               height: 1000000px;
               left: 0;
               top: 0;
          }
          
          .chartjs-size-monitor-shrink> div {
               position: absolute;
               width: 200%;
               height: 200%;
               left: 0;
               top: 0;
          }
          
          
          section.content{
	min-height: calc(100vh - 76px);
	transition: .5s;
          }
          
     </style>
     <style>
select {
	width: 100%;
	padding: 7px;
	border: 0px;
	background: #e1e1e1;
	-moz-appearance: none;
	-webkit-appearance: none;
	appearance: none;
	border-radius: 5px;
}           
     .has_select {
     width: 100%;
     display: block;
     }
          
     .has_select i {
	position: absolute;
	right: 7px;
	font-size: 21px;
	top: 4px;
     }
 /* The container must be positioned relative: */
.custom-select {
  position: relative;
  font-family: Arial;
}

.custom-select select {
  display: none; /*hide original SELECT element: */
}

.select-selected {
  background-color: #eee;
}

/* Style the arrow inside the select element: */
/* Point the arrow upwards when the select box is open (active): */
.select-selected.select-arrow-active:after {
  border-color: transparent transparent #fff transparent;
  top: 7px;
}

/* style the items (options), including the selected item: */
.select-items div, .select-selected {
	color: #333;
	padding: 8px 16px;
	/* border: 1px solid transparent; */
	/* border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent; */
	cursor: pointer;
	margin: -7px -18px;
	margin-right: -29px;
	border-radius: 5px;
}
          
.select-items div, .select-selected .option {
	cursor: pointer;
	margin: 0px;
}
          
/* Style items (options): */
.select-items {
	position: absolute;
	background-color: #EDEDED;
	top: 100%;
	left: 0;
	right: 0;
	z-index: 99;
	margin-top: 2px;
	max-height: 145px;
	overflow: auto;
}
/* Hide the items when the select box is closed: */
.select-hide {
  display: none;
}

.select-items div:hover, .same-as-selected {
  background-color: rgba(0, 0, 0, 0.1);
}           
  
#toast {
	padding: 10px;
	background: #606060;
	border-radius: 5px;
	width: 100%;
	text-align: center;
	color: #fff;
	margin: auto;
	transition: 0.8s all;
	margin-bottom: 40px;
     display: none;
}
          
#toast p{
     margin: 0px;               
}   
          
     .inserted_suc {
	text-align: center;
	padding: 20px;
	background: green;
	color: #fff;
          } 
          
          
.myModal {
     transition: 0.8s all;
	position: absolute;
	top: 50%;
	left: 50%;
	background: #FFFFFF;
	color: #3F3F3F;
	padding: 10px;
	border-radius: 5px;
	width: 300px;
	transform: translate(-50%,-50%);
     z-index: 110000;
     transform: scale(0);
}
  
          
          .myModalActive {
                    transform: scale(1) translate(-50%,-50%);
          }
          
     .myModal input{
	width: 100%;
	background: transparent;
	border: 0px;
	border-bottom: 1px solid #000;
     }          
      
          
          .myModal .mymodal_title{
	width: 100%;
	padding: 10px 0px;
	display: block;
	border-bottom: 1px solid rgba(0, 0, 0, 0.31);
	padding-bottom: 1px;
	margin-bottom: 10px;
          }     
.outer {
	position: absolute;
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,0.46);
	z-index: 11000;
	top: 0;
     display: none;
}   
          
.myModal button {
	margin-top: 9px;
	width: 100%;
	background: #353535 !important;
}          
          
     </style>

<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">
<body class="light menu_light logo-white theme-white">
               <div class="outer"></div>     
          <app-sidebar _ngcontent-pjk-c62="" _nghost-pjk-c61="" class="ng-star-inserted">
          <!---->
          <app-main _nghost-pjk-c134="" class="ng-star-inserted">
               <section  class="content">
                    <div  class="container-fluid" style="margin-top: 80px;">
     <div _ngcontent-scr-c151="" class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
          <div _ngcontent-scr-c151="" class="card" style="border: 1px solid #17f4ff;">
               <div _ngcontent-scr-c151="" class="header">
                    <h2 _ngcontent-scr-c151="">Edit System</h2>
               </div>
               <div _ngcontent-scr-c151="" class="body">
                                   <div id="Toast"></div>          
<?php foreach($theadminData as $adminData ){ ?>
                    <form class="m-4" id="pdateUser">
                         <div _ngcontent-scr-c151="" class="row">

                              <div _ngcontent-scr-c151="" class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                   <mat-form-field _ngcontent-scr-c151="" class="mat-form-field example-full-width ng-tns-c84-66 mat-primary mat-form-field-type-mat-input mat-form-field-appearance-legacy mat-form-field-can-float mat-form-field-has-label mat-form-field-hide-placeholder ng-untouched ng-pristine ng-invalid">
                                        <div class="mat-form-field-wrapper ng-tns-c84-66">
                                             <div class="mat-form-field-flex ng-tns-c84-66">
                                                  <!---->
                                                  <!---->
                                                  <div class="mat-form-field-infix ng-tns-c84-66">
               <input required="" class="mat-input-element mat-form-field-autofill-control cdk-text-field-autofill-monitored" placeholder="Arabic Title" value="<?php echo $adminData['AR_Title'] ?>" name="Arabic_Title">
               <span class="mat-form-field-label-wrapper ng-tns-c84-66">
          <label class="mat-form-field-label ng-tns-c84-66 mat-empty mat-form-field-empty ng-star-inserted" id="mat-form-field-label-103" for="mat-input-34" aria-owns="mat-input-34">
                                                       <!---->
                                                       </label>
                                                       <!---->
                                                       </span>
                                                  </div>
                                                  <div class="mat-form-field-suffix ng-tns-c84-66 ng-star-inserted">
                                                       <mat-icon _ngcontent-scr-c151="" role="img" matsuffix="" class="mat-icon notranslate material-icons mat-icon-no-color ng-tns-c84-66" aria-hidden="true" data-mat-icon-type="font">create</mat-icon>
                                                  </div>
                                                  <!---->
                                             </div>
                                             <div class="mat-form-field-underline ng-tns-c84-66 ng-star-inserted"><span class="mat-form-field-ripple ng-tns-c84-66"></span>
                                             </div>
                                             <!---->
                                             <div class="mat-form-field-subscript-wrapper ng-tns-c84-66">
                                                  <!---->
                                                  <div class="mat-form-field-hint-wrapper ng-tns-c84-66 ng-trigger ng-trigger-transitionMessages ng-star-inserted" style="opacity: 1; transform: translateY(0%);">
                                                       <!---->
                                                       <div class="mat-form-field-hint-spacer ng-tns-c84-66"></div>
                                                  </div>
                                                  <!---->
                                             </div>
                                        </div>
                                   </mat-form-field>
                              </div>
                              <div _ngcontent-scr-c151="" class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                   <mat-form-field _ngcontent-scr-c151="" class="mat-form-field example-full-width ng-tns-c84-66 mat-primary mat-form-field-type-mat-input mat-form-field-appearance-legacy mat-form-field-can-float mat-form-field-has-label mat-form-field-hide-placeholder ng-untouched ng-pristine ng-invalid">
                                        <div class="mat-form-field-wrapper ng-tns-c84-66">
                                             <div class="mat-form-field-flex ng-tns-c84-66">
                                                
                                                  <div class="mat-form-field-infix ng-tns-c84-66">
               <input required="" class="mat-input-element mat-form-field-autofill-control cdk-text-field-autofill-monitored" placeholder="English Title" value="<?php echo $adminData['EN_Title'] ?>" name="English_Title">
               <span class="mat-form-field-label-wrapper ng-tns-c84-66">
          <label class="mat-form-field-label ng-tns-c84-66 mat-empty mat-form-field-empty ng-star-inserted" id="mat-form-field-label-103" for="mat-input-34" aria-owns="mat-input-34">
                                                       <!---->
                                                       </label>
                                                       <!---->
                                                       </span>
                                                  </div>
                                                  
                                                  <div class="mat-form-field-suffix ng-tns-c84-66 ng-star-inserted">
                                                       <mat-icon _ngcontent-scr-c151="" role="img" matsuffix="" class="mat-icon notranslate material-icons mat-icon-no-color ng-tns-c84-66" aria-hidden="true" data-mat-icon-type="font">create</mat-icon>
                                                  </div>
                                                  <!---->
                                             </div>
                                             <div class="mat-form-field-underline ng-tns-c84-66 ng-star-inserted"><span class="mat-form-field-ripple ng-tns-c84-66"></span>
                                             </div>
                                             <!---->
                                             <div class="mat-form-field-subscript-wrapper ng-tns-c84-66">
                                                  <!---->
                                                  <div class="mat-form-field-hint-wrapper ng-tns-c84-66 ng-trigger ng-trigger-transitionMessages ng-star-inserted" style="opacity: 1; transform: translateY(0%);">
                                                       <!---->
                                                       <div class="mat-form-field-hint-spacer ng-tns-c84-66"></div>
                                                  </div>
                                                  <!---->
                                             </div>
                                        </div>
                                   </mat-form-field>
                              </div>
                         </div>
                         <div _ngcontent-scr-c151="" class="row">

                              <div _ngcontent-scr-c151="" class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                   <mat-form-field _ngcontent-scr-c151="" class="mat-form-field example-full-width ng-tns-c84-66 mat-primary mat-form-field-type-mat-input mat-form-field-appearance-legacy mat-form-field-can-float mat-form-field-has-label mat-form-field-hide-placeholder ng-untouched ng-pristine ng-invalid">
                                        <div class="mat-form-field-wrapper ng-tns-c84-66">
                                             <div class="mat-form-field-flex ng-tns-c84-66">
                                                  <!---->
                                                  <!---->
                                                  <div class="mat-form-field-infix ng-tns-c84-66">
               <input required="" class="mat-input-element mat-form-field-autofill-control cdk-text-field-autofill-monitored" placeholder="Manager" value="<?php echo $adminData['Manager'] ?>" name="Manager">
               <span class="mat-form-field-label-wrapper ng-tns-c84-66">
          <label class="mat-form-field-label ng-tns-c84-66 mat-empty mat-form-field-empty ng-star-inserted" id="mat-form-field-label-103" for="mat-input-34" aria-owns="mat-input-34">
                                                       <!---->
                                                       </label>
                                                       <!---->
                                                       </span>
                                                  </div>
                                                  <div class="mat-form-field-suffix ng-tns-c84-66 ng-star-inserted">
                                                       <mat-icon _ngcontent-scr-c151="" role="img" matsuffix="" class="mat-icon notranslate material-icons mat-icon-no-color ng-tns-c84-66" aria-hidden="true" data-mat-icon-type="font">person</mat-icon>
                                                  </div>
                                                  <!---->
                                             </div>
                                             <div class="mat-form-field-underline ng-tns-c84-66 ng-star-inserted"><span class="mat-form-field-ripple ng-tns-c84-66"></span>
                                             </div>
                                             <!---->
                                             <div class="mat-form-field-subscript-wrapper ng-tns-c84-66">
                                                  <!---->
                                                  <div class="mat-form-field-hint-wrapper ng-tns-c84-66 ng-trigger ng-trigger-transitionMessages ng-star-inserted" style="opacity: 1; transform: translateY(0%);">
                                                       <!---->
                                                       <div class="mat-form-field-hint-spacer ng-tns-c84-66"></div>
                                                  </div>
                                                  <!---->
                                             </div>
                                        </div>
                                   </mat-form-field>
                              </div>
                              <div _ngcontent-scr-c151="" class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                   <mat-form-field _ngcontent-scr-c151="" class="mat-form-field example-full-width ng-tns-c84-66 mat-primary mat-form-field-type-mat-input mat-form-field-appearance-legacy mat-form-field-can-float mat-form-field-has-label mat-form-field-hide-placeholder ng-untouched ng-pristine ng-invalid">
                                        <div class="mat-form-field-wrapper ng-tns-c84-66">
                                             <div class="mat-form-field-flex ng-tns-c84-66">
                                                
                                                  <div class="mat-form-field-infix ng-tns-c84-66">
               <input required="" class="mat-input-element mat-form-field-autofill-control cdk-text-field-autofill-monitored" placeholder="Phone Number" value="<?php echo $adminData['Tel'] ?>" name="Phone_Number">
               <span class="mat-form-field-label-wrapper ng-tns-c84-66">
          <label class="mat-form-field-label ng-tns-c84-66 mat-empty mat-form-field-empty ng-star-inserted" id="mat-form-field-label-103" for="mat-input-34" aria-owns="mat-input-34">
                                                       <!---->
                                                       </label>
                                                       <!---->
                                                       </span>
                                                  </div>
                                                  
                                                  <div class="mat-form-field-suffix ng-tns-c84-66 ng-star-inserted">
                                                       <mat-icon _ngcontent-scr-c151="" role="img" matsuffix="" class="mat-icon notranslate material-icons mat-icon-no-color ng-tns-c84-66" aria-hidden="true" data-mat-icon-type="font">local_phone</mat-icon>
                                                  </div>
                                                  <!---->
                                             </div>
                                             <div class="mat-form-field-underline ng-tns-c84-66 ng-star-inserted"><span class="mat-form-field-ripple ng-tns-c84-66"></span>
                                             </div>
                                             <!---->
                                             <div class="mat-form-field-subscript-wrapper ng-tns-c84-66">
                                                  <!---->
                                                  <div class="mat-form-field-hint-wrapper ng-tns-c84-66 ng-trigger ng-trigger-transitionMessages ng-star-inserted" style="opacity: 1; transform: translateY(0%);">
                                                       <!---->
                                                       <div class="mat-form-field-hint-spacer ng-tns-c84-66"></div>
                                                  </div>
                                                  <!---->
                                             </div>
                                        </div>
                                   </mat-form-field>
                              </div>
                         </div>
                         
                         <div _ngcontent-scr-c151="" class="row">
                              <div _ngcontent-scr-c151="" class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                   <mat-form-field _ngcontent-scr-c151="" class="mat-form-field example-full-width ng-tns-c84-66 mat-primary mat-form-field-type-mat-input mat-form-field-appearance-legacy mat-form-field-can-float mat-form-field-has-label mat-form-field-hide-placeholder ng-untouched ng-pristine ng-invalid">
                                        <div class="mat-form-field-wrapper ng-tns-c84-66">
                                        <div class="has_select">   
                                             <!-- Surround the select box within a "custom-select" DIV element.
Remember to set the width: -->
<div class="custom-select" style="width:100%;">
  <select name="Client_type">
    <option value="<?php echo $adminData['Type']; ?>" class="option" > <?php echo $adminData['Type']; ?> </option>
  </select>
</div>
                                             <!---->
                                             <div class="mat-form-field-subscript-wrapper ng-tns-c84-66">
                                                  <!---->
                                                  <div class="mat-form-field-hint-wrapper ng-tns-c84-66 ng-trigger ng-trigger-transitionMessages ng-star-inserted" style="opacity: 1; transform: translateY(0%);">
                                                       <!---->
                                                       <div class="mat-form-field-hint-spacer ng-tns-c84-66"></div>
                                                  </div>
                                                  <!---->
                                             </div>
                                        </div>
                                   </mat-form-field>
                              </div>
                              </div>               
                         <div _ngcontent-scr-c151="" class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
                                   <mat-form-field _ngcontent-scr-c151="" class="mat-form-field example-full-width ng-tns-c84-66 mat-primary mat-form-field-type-mat-input mat-form-field-appearance-legacy mat-form-field-can-float mat-form-field-has-label mat-form-field-hide-placeholder ng-untouched ng-pristine ng-invalid">
                                        <div class="mat-form-field-wrapper ng-tns-c84-66">
                                        <div class="has_select">   
                                             <!-- Surround the select box within a "custom-select" DIV element.
Remember to set the width: -->
<div class="custom-select" style="width:100%;">
  <select name="Client_Department">
    <option value="<?php echo $adminData['Department']; ?>" class="option" > <?php echo $adminData['Department']; ?> </option>
  </select>
</div>
                                             <!---->
                                             <div class="mat-form-field-subscript-wrapper ng-tns-c84-66">
                                                  <!---->
                                                  <div class="mat-form-field-hint-wrapper ng-tns-c84-66 ng-trigger ng-trigger-transitionMessages ng-star-inserted" style="opacity: 1; transform: translateY(0%);">
                                                       <!---->
                                                       <div class="mat-form-field-hint-spacer ng-tns-c84-66"></div>
                                                  </div>
                                                  <!---->
                                             </div>
                                        </div>
                                   </mat-form-field>
                              </div>
                         </div>     
<?php 
$contriesarray = $this->db->query('SELECT * FROM `countries` ORDER BY `countries`.`name` ASC')->result_array();                             
?>
                         <div _ngcontent-scr-c151="" class="col-xl-12 col-lg-6 col-md-6 col-sm-12 mb-3">
                                   <mat-form-field _ngcontent-scr-c151="" class="mat-form-field example-full-width ng-tns-c84-66 mat-primary mat-form-field-type-mat-input mat-form-field-appearance-legacy mat-form-field-can-float mat-form-field-has-label mat-form-field-hide-placeholder ng-untouched ng-pristine ng-invalid">
                                        <div class="mat-form-field-wrapper ng-tns-c84-66">
                                        <div class="has_select">   
                                             <!-- Surround the select box within a "custom-select" DIV element.
Remember to set the width: -->
<div class="custom-select" style="width:100%;">
  <select name="cousntrie">
     <?php
          $contries = $this->db->query("SELECT * FROM `countries` 
          WHERE id = '".$adminData['CountryID']."' ORDER BY `countries`.`name` ASC")->result_array();               foreach($contries as $contrie){     
               $name_con = $contrie['name'];              
               $id_con = $contrie['id'];
          } 
       ?>
    <option value="<?php echo $id_con ?>" class="option" > <?php echo $name_con ?> </option>
  </select>
</div>
                                             <!---->
                                             <div class="mat-form-field-subscript-wrapper ng-tns-c84-66">
                                                  <!---->
                                                  <div class="mat-form-field-hint-wrapper ng-tns-c84-66 ng-trigger ng-trigger-transitionMessages ng-star-inserted" style="opacity: 1; transform: translateY(0%);">
                                                       <!---->
                                                       <div class="mat-form-field-hint-spacer ng-tns-c84-66"></div>
                                                  </div>
                                                  <!---->
                                             </div>
                                        </div>
                                   </mat-form-field>
                              </div>
                              
                              </div>                      

     <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
     <button _ngcontent-gvm-c151="" mat-raised-button="" color="primary" class="mat-focus-indicator mr-3 mat-raised-button mat-button-base mat-primary" type="Submit">
     <span class="mat-button-wrapper">Submit</span>
     <span matripple="" class="mat-ripple mat-button-ripple"></span>
     <span class="mat-button-focus-overlay"></span>
     </button>
     <button _ngcontent-gvm-c151="" type="button" id="back" mat-button="" class="mat-focus-indicator mat-button mat-button-base">
     <span class="mat-button-wrapper">Cancel</span>
     <span matripple="" class="mat-ripple mat-button-ripple"></span><span class="mat-button-focus-overlay"></span>
     </button>
     </div>
                    </form>
                         <?php }  ?>
          </div>
     </div>
</div>                    </div>

                         
               </section>
<script>
$('input:not(.staticinput)').slidinput({
	  mode: 'above',
});     
    
var x, i, j, l, ll, selElmnt, a, b, c;
/* Look for any elements with the class "custom-select": */
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /* For each element, create a new DIV that will act as the selected item: */
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /* For each element, create a new DIV that will contain the option list: */
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /* For each option in the original select element,
    create a new DIV that will act as an option item: */
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /* When an item is clicked, update the original select box,
        and the selected item: */
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
    /* When the select box is clicked, close any other select boxes,
    and open/close the current select box: */
    e.stopPropagation();
    closeAllSelect(this);
    this.nextSibling.classList.toggle("select-hide");
    this.classList.toggle("select-arrow-active");
  });
}

function closeAllSelect(elmnt) {
  /* A function that will close all select boxes in the document,
  except the current select box: */
  var x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}

/* If the user clicks anywhere outside the select box,
then close all select boxes: */
document.addEventListener("click", closeAllSelect);      

     
$("#pdateUser").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>AR/users/startUpdatingSystem',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
               $('#Toast').css('display','block');
               $('#Toast').html(data);

          },
          ajaxError: function(){
               $('.alert.alert-info').css('background-color','#DB0404');
               $('.alert.alert-info').html("Ooops! Error was found.");
          }
     });
});
    
    
     
     
$('#back').click(function(){
     location.href = "<?php echo base_url()."Dashboard"; ?>";
});     

          
// Cancel *
     
$('#back').click(function(){
     location.href = "<?php echo base_url()."Dashboard"; ?>";
});     
     
function back(){
     location.href = "<?php echo base_url()."Dashboard"; ?>";
}     
     
function sendbyemail(){
   $('.myModal').addClass('myModalActive');  
   $('.outer').css('display','block');  
 }
    
     
     
     
</script>
               
</body>

</html>