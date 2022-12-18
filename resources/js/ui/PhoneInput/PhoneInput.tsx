import * as React from 'react';
import classnames from 'classnames';
import PhoneInput from 'react-phone-input-2';

interface IPhoneInput {
    value: string;
    label?: string | false;
    onChange: (value: string) => void;
    defaultCountry: string;
    phoneError?: boolean | string;
}

const PhoneInputComponent = ({
    phoneError = false,
    value = '',
    onChange,
    label = 'Телефон',
    defaultCountry = 'ru',
}: IPhoneInput): any => {
    return (
        <div
            className={classnames('legrand-phone-input-wrapper', {
                'legrand-phone-input-with-label': label,
            })}
        >
            <div className="legrand-phone-input-labels">
                {label && <span className="legrand-phone-input-label">{label}</span>}
                {phoneError && <span className="legrand-phone-input-error">{phoneError}</span>}
            </div>

            <PhoneInput
                containerClass="legrand-phone-input-component"
                inputClass="legrand-phone-input-control"
                value={value}
                onChange={onChange}
                placeholder="Телефон"
            />
        </div>
    );
};

export default PhoneInputComponent;
