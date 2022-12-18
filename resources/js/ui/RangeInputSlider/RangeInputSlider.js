"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const antd_1 = require("antd");
const RangeInputSlider = ({ values, min, max, step, onChange }) => {
    const handleChange = (values) => {
        onChange(values);
    };
    return (React.createElement(antd_1.Slider, { range: true, defaultValue: values, value: values, min: min, max: max, step: step, className: "legweb-range-input-slider", tipFormatter: null, onChange: handleChange }));
};
exports.default = RangeInputSlider;
