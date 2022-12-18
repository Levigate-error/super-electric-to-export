import * as React from "react";

interface IAttributes {
    atrributes: TAttribute[];
}

type TAttribute = {
    title: string;
    value: string;
};

function Attributes({ atrributes }: IAttributes) {
    return (
        <ul className="attributes-list">
            {atrributes.map((item: TAttribute) => (
                <li key={item.title}>
                    {item.title} <span>{item.value}</span>
                </li>
            ))}
        </ul>
    );
}

export default React.memo(Attributes);
