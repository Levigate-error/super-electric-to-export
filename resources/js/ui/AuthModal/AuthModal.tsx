import * as React from "react";
import classnames from "classnames";
import Rodal from "rodal";
import Button from "../Button";
import Input from "../Input";
import CheckBox from "../Checkbox";

import { userAuth } from "./api";

interface IAuthModal {
    children: React.ReactNode;
}

const initialState = {
    atuthScreenIsVisible: false,
    email: "",
    password: "",
    remember: false,
    modalVisibility: false,
    isAuth: false
};

function reducer(state, { type, payload }) {
    switch (type) {
        case "set-user-is-auth":
            return { ...state, isAuth: payload };
        case "modal-visibility":
            return { ...state, modalVisibility: payload };
        case "set-email":
            return { ...state, email: payload };
        case "set-password":
            return { ...state, password: payload };
        case "set-remember":
            return { ...state, remember: payload };
        case "set-errors":
            return { ...state, errors: payload };
        case "set-auth-visibility":
            return { ...state, atuthScreenIsVisible: payload };
        case "reset":
            return { ...payload };

        default:
            throw new Error();
    }
}
declare global {
    interface Window {
        __USER__: any;
    }
}

function AuthModal({ children }: IAuthModal) {
    const [state, dispatch] = React.useReducer(reducer, initialState);

    React.useEffect(() => {
        dispatch({
            type: "set-user-is-auth",
            payload: !!(typeof window !== "undefined" && window.__USER__)
        });
    }, []);

    const getToken = () => {
        if (typeof window !== "undefined") {
            const m = document.getElementsByTagName("meta");
            for (var i in m) {
                if (m[i].name == "csrf-token") {
                    return m[i].content;
                }
            }
        }
        return "";
    };

    const _token = getToken();

    const showAuth = () => {
        dispatch({ type: "set-auth-visibility", payload: true });
    };

    const showModal = e => {
        state.isAuth || dispatch({ type: "modal-visibility", payload: true });
    };

    const hideModal = e => {
        dispatch({ type: "reset", payload: initialState });
    };

    const sendAuthData = () => {
        const { email, password, remember } = state;
        dispatch({ type: "set-errors", payload: false });

        const req = { email, password, remember, _token };

        userAuth({ ...req }).then(response => {
            const { errors } = response;
            errors
                ? dispatch({
                      type: "set-errors",
                      payload: Object.keys(errors).map(key => {
                          return errors[key][0];
                      })
                  })
                : window.location.reload();
        });
    };

    const handleRegister = () => {
        const base_url = window.location.origin;
        window.location.href = `${base_url}/register`;
    };

    const setRemember = React.useCallback(
        value =>
            dispatch({
                type: "set-remember",
                payload: value
            }),
        [dispatch]
    );

    const setEmailValue = React.useCallback(
        ({ target: { value } }) =>
            dispatch({
                type: "set-email",
                payload: value
            }),
        [dispatch]
    );

    const setPasswordValue = React.useCallback(
        ({ target: { value } }) =>
            dispatch({
                type: "set-password",
                payload: value
            }),
        [dispatch]
    );

    return (
        <React.Fragment>
            <span
                onClick={showModal}
                className={classnames({
                    "auth-modal-click-wrapper": !state.isAuth
                })}
            >
                {children}
            </span>
            <Rodal
                visible={state.modalVisibility}
                onClose={hideModal}
                height={265}
                width={320}
            >
                {state.atuthScreenIsVisible ? (
                    <div className="auth-modal-wrapper">
                        <form>
                            <div className="form-group row">
                                <label>
                                    E-mail
                                    <Input
                                        value={state.email}
                                        onChange={setEmailValue}
                                    />
                                </label>
                            </div>
                            <div className="form-group row">
                                <label>
                                    Пароль
                                    <Input
                                        value={state.password}
                                        onChange={setPasswordValue}
                                        type="password"
                                    />
                                </label>
                            </div>
                            <div className="form-group row">
                                <CheckBox
                                    label="Запомнить меня"
                                    name="remember"
                                    checked={state.remember}
                                    onChange={setRemember}
                                />
                            </div>
                            {state.errors && (
                                <div className="form-group row">
                                    {state.errors.map(error => {
                                        return (
                                            <span
                                                className="form-error-msg"
                                                key={error}
                                            >
                                                {error}
                                            </span>
                                        );
                                    })}
                                </div>
                            )}
                            <div className="form-group row login-btn-wrapper">
                                <Button onClick={sendAuthData} value="Войти" />
                            </div>
                        </form>
                    </div>
                ) : (
                    <div className="auth-modal-wrapper">
                        <span className="auth-modal-header">
                            Чтобы сохранить или показать избранные товары,
                            пожалуйста зарегистрируйтесь или авторизуйтесь.
                        </span>
                        <div className="auth-modal-btns">
                            <Button
                                value="Авторизация"
                                onClick={showAuth}
                                appearance="bordered"
                            />
                            <Button
                                value="Регистрация"
                                onClick={handleRegister}
                                appearance="accent"
                            />
                        </div>
                    </div>
                )}
            </Rodal>
        </React.Fragment>
    );
}

export default AuthModal;
