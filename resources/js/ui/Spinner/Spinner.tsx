import * as React from "react";
import classnames from "classnames";

interface ISpinner {
    type?: "default" | "white";
    style?: any;
}
function Spinner({ type, style = {} }: ISpinner) {
    return (
        <div
            className={classnames("lds-spinner", type || "default")}
            style={style}
        >
            <div />
            <div />
            <div />
            <div />
            <div />
            <div />
            <div />
            <div />
            <div />
            <div />
            <div />
            <div />
        </div>
    );
}

export default Spinner;
