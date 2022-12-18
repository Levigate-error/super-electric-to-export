import * as React from 'react';
interface ICheckbox {
    disabled?: boolean;
    checked: boolean;
    label?: any;
    name?: string;
    onChange: (value: boolean) => void;
    tabindex?: number;
    id?: number;
}

function Checkbox({ disabled, checked, onChange, label, name = '', tabindex = 0, id }: ICheckbox) {
    const handleChange = e => {
        const value = e.target.checked;
        onChange(value);
    };

    return (
        <label className="ui-checkbox">
            {label}
            <input
                type="checkbox"
                checked={checked}
                disabled={disabled}
                onChange={handleChange}
                name={name}
                tabIndex={tabindex}
                data-id={id || ''}
            />
            <span className="checkmark" />
        </label>
    );
}

export default React.memo(Checkbox);
