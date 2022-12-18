import * as React from 'react';
import classnames from 'classnames';

interface IInput {
    value: string | number;
    onChange?: (event: any) => void;
    type?: string;
    disabled?: boolean;
    minMax?: TMinMax;
}

type TMinMax = {
    min: number;
    max: number;
};

function Input({ value, onChange = () => {}, type = 'number', disabled, minMax }: IInput) {
    const inputEl = React.useRef(null);

    React.useEffect(() => {
        inputEl.current.value = value;
    }, [value]);

    const handleChange = e => {
        if (!disabled) {
            if (minMax && type === 'number') {
                const { min, max } = minMax;
                let val: any = parseInt(e.target.value);

                inputEl.current.value = `${val}`;

                val = val <= min ? min : val >= max ? max : val;

                onChange(val);
            } else {
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

    return (
        <div
            className={classnames('legrand-input-wrapper', {
                'legrand-input-disabled': disabled,
            })}
        >
            <input
                type={type}
                ref={inputEl}
                className="form-control shadow-none legrand-input"
                onChange={handleChange}
                onBlur={handleBlur}
                required
                disabled={disabled}
            />
        </div>
    );
}

export default React.memo(Input);
