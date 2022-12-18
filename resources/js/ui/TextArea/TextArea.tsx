import * as React from 'react';
import classnames from 'classnames';

interface ITextarea {
    rows?: number;
    value: string;
    name?: string;
    disabled?: boolean;
    label?: string;
    error?: string;
    onChange?: (event: any) => void;
    maxLength?: number;
}
const TextArea = ({
    rows = 5,
    maxLength = 1000,
    name = 'textarea1',
    value,
    disabled = false,
    label,
    onChange = () => {},
    error,
}: ITextarea) => {
    const handleChange = e => {
        if (!disabled) {
            onChange(e);
        }
    };

    return (
        <div className={classnames('legrand-textarea-wrapper', { 'with-label': label })}>
            <div className="legrand-textarea-labels">
                {label && <span className="label-wrapper">{label}</span>}
                {error && <span className="legrand-textarea-error">{error}</span>}
            </div>

            <textarea
                className={classnames('legrand-textarea', { 'legrand-textarea-disabled': disabled })}
                name={name}
                rows={rows}
                onChange={handleChange}
                value={value}
                maxLength={maxLength}
            ></textarea>
        </div>
    );
};

export default TextArea;
