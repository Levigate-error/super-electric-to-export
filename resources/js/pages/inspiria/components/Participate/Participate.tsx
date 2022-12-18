import * as React from 'react';
import Button from '../../../../ui/Button';
import Input from '../../../../ui/Input';
import { registerVIN } from '../../api';
import { Icon } from 'antd';
import { initialState, reducer, actionTypes } from './reducer';
import { UserContext } from '../../../../components/PageLayout/PageLayout';

interface IParticipate {
    close: () => void;
}

const firstStepStyle = {
    btn: {
        width: 170,
    },
    link: {
        marginTop: 8,
    },
};

const secondStepStyle = {
    btn: {
        width: 210,
        marginTop: 40,
    },
    text: {
        marginTop: 20,
        marginBottom: 40,
    },
    icon: {
        marginLeft: 10,
    },
};

const thirdStepStyle = {
    btn: {
        width: 100,
        marginTop: 40,
    },
    text: {
        marginTop: 40,
    },
};

const Participate = ({ close }: IParticipate) => {
    const [{ step, vin, isLoading, error, codeError, loyaltyError }, dispatch] = React.useReducer(
        reducer,
        initialState,
    );

    const usrCtx = React.useContext(UserContext);

    const handleToStepTwo = () => {
        dispatch({ type: actionTypes.SET_STEP, payload: 2 });
    };

    const handleToStepThree = () => {
        dispatch({ type: actionTypes.REGISTER });
        registerVIN(vin)
            .then(response => {
                if (response.errors) {
                    response.errors.code &&
                        dispatch({
                            type: actionTypes.CODE_ERROR,
                            payload: response.errors.code[0],
                        });
                    response.errors.loyalty_id &&
                        dispatch({
                            type: actionTypes.LOYALTY_ID_ERROR,
                            payload: response.errors.loyalty_id[0],
                        });
                } else if (response.message) {
                    dispatch({
                        type: actionTypes.FIELD_ERROR,
                        payload: response.message,
                    });
                } else {
                    dispatch({ type: actionTypes.SET_STEP, payload: 3 });
                }
            })
            .catch(err => {});
    };

    const handleChangeVIN = e => {
        dispatch({ type: actionTypes.SET_VIN, payload: e.target.value });
    };

    const handleComplete = () => {
        close();
        location.reload();
    };

    const hasPhoto = !!usrCtx.userResource.photo;

    return (
        <div className="loyality-modal-wrapper">
            {step === 1 && (
                <React.Fragment>
                    <h3>У Вас есть идентификационный номер сертификата?</h3>
                    <div className="loyality-modal-controls">
                        <Button onClick={handleToStepTwo} value="Да" style={firstStepStyle.btn} />
                        <a href="https://legrand.ru/services/learning" target="_blank" style={firstStepStyle.link}>
                            Записаться на обучение
                        </a>
                    </div>
                </React.Fragment>
            )}

            {step === 2 && hasPhoto && (
                <React.Fragment>
                    <h3>Введите идентификационный номер сертификата</h3>
                    <div style={secondStepStyle.text}>Идентификационный номер сертификата указан на сертификате</div>
                    <Input
                        onChange={handleChangeVIN}
                        value={vin}
                        placeholder="Введите номер сертификата"
                        label="Идентификационный номер сертификата"
                        error={codeError}
                    />
                    {error && <span className="loyality-modal-errors">{error}</span>}
                    {loyaltyError && <span className="loyality-modal-errors">{loyaltyError}</span>}
                    <Button
                        onClick={handleToStepThree}
                        value={
                            isLoading ? (
                                <React.Fragment>
                                    Зарегистрироваться <Icon type="loading" style={secondStepStyle.icon} />
                                </React.Fragment>
                            ) : (
                                'Зарегистрироваться'
                            )
                        }
                        style={secondStepStyle.btn}
                    />
                </React.Fragment>
            )}

            {step === 2 && !hasPhoto && (
                <React.Fragment>
                    <h3>Регистрация в программе лояльности</h3>
                    <p>
                        Для участия в программе лояльности необходимо заполнить фотографию в{' '}
                        <a href="user/profile" className="legrand-text-btn">
                            профиле
                        </a>
                    </p>
                </React.Fragment>
            )}

            {step === 3 && (
                <React.Fragment>
                    <h3>Спасибо за регистрацию</h3>

                    <div style={thirdStepStyle.text}>
                        Мы рады Вашему участию
                        <br /> в нашей программе лояльности
                    </div>

                    <Button onClick={handleComplete} value="Начать" style={thirdStepStyle.btn} />
                </React.Fragment>
            )}
        </div>
    );
};

export default Participate;
