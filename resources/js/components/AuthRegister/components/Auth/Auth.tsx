import * as React from 'react';
import { reducer, initalState, actionTypes } from './reducer';
import Input from '../../../../ui/Input';
import Checkbox from '../../../../ui/Checkbox';
import Button from '../../../../ui/Button';
import { authorize } from './api';
import { setErrorHelper } from './helper';
import { Icon } from 'antd';

interface Iauth {
    restorePassword: () => void;
    csrf: string;
}

const loadingIconStyle = {
    marginLeft: 10,
};

const Auth = ({ restorePassword, csrf }: Iauth) => {
    const [{ email, emailError, password, passwordError, remember, error, isLoading }, dispatch] = React.useReducer(
        reducer,
        initalState,
    );

    const handleChangeInput = React.useCallback(
        ({ target }) => {
            switch (target.name) {
                case 'email':
                    dispatch({
                        type: actionTypes.SET_EMAIL,
                        payload: target.value,
                    });
                    break;
                case 'password':
                    dispatch({
                        type: actionTypes.SET_PASSWORD,
                        payload: target.value,
                    });
                    break;
            }
        },
        [email, password],
    );

    const handleChangeUserRemember = (value): void => dispatch({ type: actionTypes.SET_REMEMBER, payload: value });

    const handleClickRestorePassword = (): void => restorePassword();

    const handleSubmit = (e): void => {
        e.preventDefault();
        const params: any = {
            email,
            password,
            _token: csrf,
        };

        if (remember) {
            params.remember = true;
        }
        dispatch({ type: actionTypes.AUTHORIZATION });

        authorize(params)
            .then(response => {
                if (response.errors) {
                    dispatch({
                        type: actionTypes.AUTH_FAILURE,
                        payload: response.message,
                    });
                    setErrorHelper(dispatch, response.errors);
                } else if (response.message && !response.errors) {
                    dispatch({
                        type: actionTypes.AUTH_FAILURE,
                        payload: response.message,
                    });
                } else {
                    if (typeof window !== 'undefined') document.location.reload();
                }
            })
            .catch(err => {});
    };

    const sumbmitAvailable = emailError || passwordError || error;

    return (
        <div>
            <h3 className="auth-register-modal-title">Войти</h3>
            <div className="auth-register-input-row">
                <Input
                    value={email}
                    onChange={handleChangeInput}
                    error={emailError}
                    label="E-mail"
                    placeholder="Введите E-mail"
                    tabindex={1}
                    name="email"
                />
            </div>
            <div className="auth-register-input-row">
                <Input
                    value={password}
                    onChange={handleChangeInput}
                    label="Пароль"
                    placeholder="Введите пароль"
                    error={passwordError}
                    isPassword
                    tabindex={2}
                    name="password"
                />
            </div>
            <div className="auth-register-controls">
                <Checkbox checked={remember} onChange={handleChangeUserRemember} label="Запомнить" tabindex={3} />

                <button className="legrand-text-btn" onClick={handleClickRestorePassword} tabIndex={5}>
                    Забыли пароль?
                </button>
            </div>

            {error && (
                <div className="auth-register-error-text-wrapper" dangerouslySetInnerHTML={{ __html: error }}></div>
            )}

            <div className="auth-register-input-row auth-register-confirm">
                <Button
                    onClick={handleSubmit}
                    value={
                        isLoading ? (
                            <React.Fragment>
                                Войти <Icon type="loading" style={loadingIconStyle} />
                            </React.Fragment>
                        ) : (
                            'Войти'
                        )
                    }
                    appearance="accent"
                    disabled={sumbmitAvailable}
                    type="submit"
                    tabindex={4}
                />
            </div>
        </div>
    );
};

export default Auth;
