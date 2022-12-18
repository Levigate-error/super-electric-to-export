import * as React from 'react';
import { Slider } from 'antd';

interface IRangeInputSlider {
    step: number;
    min: number;
    max: number;
    values: any;
    onChange: (values: number[]) => void;
}

const RangeInputSlider = ({ values, min, max, step, onChange }: IRangeInputSlider): React.ReactElement => {
    const handleChange = (values): void => {
        onChange(values);
    };

    return (
        <Slider
            range
            defaultValue={values}
            value={values}
            min={min}
            max={max}
            step={step}
            className="legweb-range-input-slider"
            tipFormatter={null}
            onChange={handleChange}
        />
    );
};

export default RangeInputSlider;
