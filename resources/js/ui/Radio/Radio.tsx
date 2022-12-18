import * as React from 'react';

interface IRadio {
    values: TRadio[];
    onChange: (e: any) => void;
    defaultValue: number;
}

type TRadio = {
    id: number;
    value: number;
    text: string;
    disabled?: boolean;
};

const Radio = ({ values, onChange, defaultValue }: IRadio) => {
    const [selected, setSelected] = React.useState(defaultValue);

    const handleOptionChange = e => {
        const value = parseInt(e.target.value);
        setSelected(value);
        onChange(value);
    };

    return (
        <form>
            {values.map(item => (
                <div className="radio">
                    <input
                        id={`radio-${item.id}`}
                        value={item.value}
                        name="radio"
                        type="radio"
                        onChange={handleOptionChange}
                        checked={selected === item.value}
                    />
                    <label htmlFor={`radio-${item.id}`} className="radio-label">
                        {item.text}
                    </label>
                </div>
            ))}
        </form>
    );
};

export default Radio;
