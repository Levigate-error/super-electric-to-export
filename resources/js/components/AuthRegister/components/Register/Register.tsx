import * as React from 'react';
import { reducer, initalState, actionTypes } from './reducer';
import Input from '../../../../ui/Input';
import Checkbox from '../../../../ui/Checkbox';
import Button from '../../../../ui/Button';
import { Icon } from 'antd';
import { register } from './api';
import { setErrorHelper } from './helper';
import CityInput from '../../../../ui/CityInput';
import PhoneInput from '../../../../ui/PhoneInput';

interface IRegister {
    csrf: string;
}

const loadingIconStyle = {
    marginLeft: 10,
};

const Register = ({ csrf }: IRegister): React.ReactElement => {
    const [
        {
            fetch,
            name,
            nameError,
            lastname,
            lastnameError,
            birthday,
            birthdayError,
            city_id,
            cityError,
            phone,
            phoneError,
            email,
            emailError,
            password,
            passwordError,
            passwordRepeat,
            passwordRepeatError,
            privacy,
            privacyError,
            subscription,
            subscriptionError,
            success,
        },
        dispatch,
    ] = React.useReducer(reducer, initalState);

    const handleChangeInput = React.useCallback(
        data => {
            // text field event or phone input
            if (data.target) {
                switch (data.target.name) {
                    case 'name':
                        dispatch({
                            type: actionTypes.SET_NAME,
                            payload: data.target.value,
                        });

                        break;
                    case 'lastname':
                        dispatch({
                            type: actionTypes.SET_LASTNAME,
                            payload: data.target.value,
                        });

                        break;
                    case 'birthday':
                        dispatch({
                            type: actionTypes.SET_BIRTHDAY,
                            payload: data.target.value,
                        });

                        break;
                    case 'email':
                        dispatch({
                            type: actionTypes.SET_EMAIL,
                            payload: data.target.value,
                        });

                        break;
                    case 'password':
                        dispatch({
                            type: actionTypes.SET_PASSWORD,
                            payload: data.target.value,
                        });

                        break;
                    case 'passwordRepeat':
                        dispatch({
                            type: actionTypes.SET_REPEAT_PASSWORD,
                            payload: data.target.value,
                        });
                        break;
                }
            } else {
                dispatch({
                    type: actionTypes.SET_PHONE,
                    payload: data,
                });
            }
        },
        [name, lastname, birthday, city_id, phone, email, password, passwordRepeat],
    );

    const handleApplyPrivacy = (value): void => dispatch({ type: actionTypes.SET_PRIVACY, payload: value });
    const handleApplySubscription = (value): void => dispatch({ type: actionTypes.SET_SUBSCRIPTION, payload: value });

    const handleSubmit = (e): void => {
        e.preventDefault();

        dispatch({ type: actionTypes.REGISTER });
        register({
            name,
            lastname,
            birthday,
            city_id,
            phone,
            email,
            password,
            passwordRepeat,
            privacy,
            subscription,
            csrf,
        })
            .then(response => {
                if (response.errors) {
                    dispatch({
                        type: actionTypes.REGISTER_FAILURE,
                        payload: response.message,
                    });
                    setErrorHelper(dispatch, response.errors);
                } else {
                    dispatch({
                        type: actionTypes.REGISTER_SUCCESS,
                        payload: response.data,
                    });
                }
            })
            .catch(err => {});
    };

    const handleSelectCity = (val): void => {
        dispatch({
            type: actionTypes.SET_CITY,
            payload: val.id,
        });
    };

    return (
        <form>
            <h3 className="auth-register-modal-title">Регистрация</h3>
            {success ? (
                <div className="auth-register-input-row">{success}</div>
            ) : (
                <React.Fragment>
                    <div className="auth-register-input-row">
                        <Input
                            value={name}
                            onChange={handleChangeInput}
                            label="Имя"
                            placeholder="Введите имя"
                            error={nameError}
                            name="name"
                        />
                    </div>
                    <div className="auth-register-input-row">
                        <Input
                            value={lastname}
                            onChange={handleChangeInput}
                            label="Фамилия"
                            placeholder="Введите фамилию"
                            error={lastnameError}
                            name="lastname"
                        />
                    </div>
                    <div className="auth-register-input-row">
                        <Input
                            value={birthday}
                            type="date"
                            onChange={handleChangeInput}
                            label="Дата рождения"
                            placeholder="Введите дату рождения"
                            error={birthdayError}
                            name="birthday"
                        />
                    </div>
                    <div className="auth-register-input-row">
                        <CityInput onSelect={handleSelectCity} error={cityError} />
                    </div>

                    <div className="auth-register-input-row">
                        <PhoneInput
                            phoneError={phoneError}
                            defaultCountry={'ru'}
                            value={phone}
                            onChange={handleChangeInput}
                        />
                    </div>
                    <div className="auth-register-input-row">
                        <Input
                            value={email}
                            onChange={handleChangeInput}
                            label="E-mail"
                            placeholder="Введите E-mail"
                            error={emailError}
                            name="email"
                        />
                    </div>
                    <div className="auth-register-input-row">
                        <Input
                            value={password}
                            onChange={handleChangeInput}
                            label="Пароль"
                            placeholder="Введите пароль"
                            isPassword
                            error={passwordError}
                            name="password"
                        />
                    </div>
                    <div className="auth-register-input-row">
                        <Input
                            value={passwordRepeat}
                            onChange={handleChangeInput}
                            label="Повторите пароль"
                            placeholder="Введите пароль"
                            isPassword
                            error={passwordRepeatError}
                            name="passwordRepeat"
                        />
                    </div>
                    <div className="auth-register-controls">
                        <span>
                            <Checkbox
                                checked={privacy}
                                onChange={handleApplyPrivacy}
                                label={
                                    <span>
                                        Подтверждаю согласие на
                                        <a
                                            className="legrand-text-btn"
                                            href="/Согласие_ПДн_Суперэлектрик.pdf"
                                            target="_blank"
                                        >
                                            {' '}
                                            обработку персональных данных
                                        </a>
                                    </span>
                                }
                            />
                        </span>
                    </div>
                    {privacyError && (
                        <div className="auth-register-controls auth-register-info-message ">{privacyError}</div>
                    )}
                    <div className="auth-register-controls">
                        <Checkbox
                            checked={subscription}
                            onChange={handleApplySubscription}
                            label={
                                <span>
                                    Подтверждаю
                                    <a
                                        className="legrand-text-btn"
                                        href="/Согласие_на_рекламу.pdf"
                                        target="_blank"
                                    >
                                        {' '}
                                        согласие{' '}
                                    </a>
                                    на получение рекламных рассылок
                                </span>
                            }
                        />
                    </div>
                    {subscriptionError && (
                        <div className="auth-register-controls auth-register-info-message ">{subscriptionError}</div>
                    )}
                    <div className="auth-register-input-row auth-register-confirm">
                        <Button
                            onClick={handleSubmit}
                            value={
                                fetch ? (
                                    <React.Fragment>
                                        Зарегистрироваться <Icon type="loading" style={loadingIconStyle} />
                                    </React.Fragment>
                                ) : (
                                    'Зарегистрироваться'
                                )
                            }
                            appearance="accent"
                            type="submit"
                        />
                    </div>
                </React.Fragment>
            )}
        </form>
    );
};

export default Register;
