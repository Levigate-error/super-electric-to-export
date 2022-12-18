import * as React from "react";
import { IParams } from "../types";

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
