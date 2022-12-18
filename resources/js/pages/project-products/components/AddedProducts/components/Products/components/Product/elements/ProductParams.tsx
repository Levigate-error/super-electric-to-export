import * as React from "react";

export type TProductAttribute = {
    title: string;
    value: string | number;
};

export interface IParams {
    params: TProductAttribute[];
}

export function ProductParams({ params }: IParams) {
    return (
        <ul className="product-params mt-3">
            {params.slice(0, 5).map(item => (
                <li className="product-param-row mt-2" key={item.title}>
                    <span>{item.title}:</span>
                    <span>{item.value}</span>
                </li>
            ))}
        </ul>
    );
}
