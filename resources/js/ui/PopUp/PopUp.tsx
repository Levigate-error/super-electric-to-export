import * as React from "react";
import classnames from "classnames";

interface IPopUp {
    isOpen: boolean;
    children: React.ReactNode;
    hiddenHeader?: boolean;
    onClose: () => void;
}

function PopUp({ isOpen, onClose, children, hiddenHeader }: IPopUp) {
    const handleClick = e => {
        e.stopPropagation();
    };

    return (
        <div
            className={classnames("modal", { "fade show": isOpen })}
            tabIndex={-1}
            role="dialog"
            onClick={onClose}
        >
            <div className="modal-dialog modal-dialog-centered" role="document">
                <div
                    className={classnames("modal-content loyalty__pop-up ", {
                        "hidden-header": hiddenHeader
                    })}
                    onClick={handleClick}
                >
                    {!hiddenHeader && (
                        <button className="modal-close-btn" onClick={onClose}>
                            <svg
                                width="19"
                                height="20"
                                viewBox="0 0 19 20"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fillRule="evenodd"
                                    clipRule="evenodd"
                                    d="M9.36143 10.9022L17.9988 19.5456L18.7057 18.8382L10.0683 10.1948L18.7057 1.55144L17.9988 0.844088L9.36143 9.48747L1.03415 1.15442L0.327284 1.86177L8.65457 10.1948L0.327284 18.5279L1.03415 19.2352L9.36143 10.9022Z"
                                    fill="black"
                                />
                            </svg>
                        </button>
                    )}
                    {children}
                </div>
            </div>
        </div>
    );
}

export default PopUp;
