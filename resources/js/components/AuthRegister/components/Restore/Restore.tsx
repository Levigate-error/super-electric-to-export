import * as React from 'react';
import { reducer, initalState, actionTypes } from './reducer';
import Input from '../../../../ui/Input';
import Button from '../../../../ui/Button';
import { reset } from './api';
import { setErrorHelper } from './helper';

interface IRestore {
    csrf: string;
}

const Restore = ({ csrf }: IRestore) => {
    const [{ email, emailError, success }, dispatch] = React.useReducer(reducer, initalState);

    const handleChangeInput = React.useCallback(
        ({ target }) => {
            switch (target.name) {
                case 'email':
                    dispatch({
                        type: actionTypes.SET_EMAIL,
                        payload: target.value,
                    });
                    break;
            }
        },
        [email],
    );

    const handleSubmit = () => {
        reset({ email, csrf })
            .then(response => {
                if (response.errors) {
                    dispatch({
                        type: actionTypes.RESET_FAILURE,
                        payload: response.message,
                    });
                    setErrorHelper(dispatch, response.errors);
                } else {
                    dispatch({
                        type: actionTypes.RESET_SUCCESS,
                    });
                }
            })
            .catch(err => {});
    };

    return (
        <div className="auth-register-modal-wrapper">
            <h3 className="auth-register-modal-title">Восстановление пароля</h3>
            {success ? (
                <div className="auth-register-input-row">
                    На указанный адрес отправлено письмо со ссылкой для восстановления пароля
                </div>
            ) : (
                <React.Fragment>
                    <div className="auth-register-input-row auth-register-reset-info">
                        Введите Ваш E-mail и мы пришлем
                        <br /> ссылку для восстановления пароля
                    </div>
                    <div className="auth-register-input-row">
                        <Input
                            value={email}
                            error={emailError}
                            onChange={handleChangeInput}
                            label="E-mail"
                            placeholder="Введите E-mail"
                            name="email"
                        />
                    </div>

                    <div className="auth-register-input-row auth-register-confirm">
                        <Button onClick={handleSubmit} value="Сбросить пароль" appearance="accent" />
                    </div>
                </React.Fragment>
            )}
        </div>
    );
};

export default Restore;
