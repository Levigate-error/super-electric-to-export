"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
function Input({ value, onChange = () => { }, type = 'number', disabled, minMax }) {
    const inputEl = React.useRef(null);
    React.useEffect(() => {
        inputEl.current.value = value;
    }, [value]);
    const handleChange = e => {
        if (!disabled) {
            if (minMax && type === 'number') {
                const { min, max } = minMax;
                let val = parseInt(e.target.value);
                inputEl.current.value = `${val}`;
                val = val <= min ? min : val >= max ? max : val;
                onChange(val);
            }
            else {
                inputEl.current.value = e.target.value;
                onChange(e);
            }
        }
    };
    const handleBlur = e => {
        const { min } = minMax;
        const val = parseInt(e.target.value);
        if (!val || val <= 0) {
            inputEl.current.value = `${min}`;
            onChange(min);
        }
    };
    return (React.createElement("div", { className: classnames_1.default('legrand-input-wrapper', {
            'legrand-input-disabled': disabled,
        }) },
        React.createElement("input", { type: type, ref: inputEl, className: "form-control shadow-none legrand-input", onChange: handleChange, onBlur: handleBlur, required: true, disabled: disabled })));
}
exports.default = React.memo(Input);
