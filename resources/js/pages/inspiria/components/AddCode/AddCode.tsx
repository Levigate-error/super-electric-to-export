import * as React from 'react';
import Button from '../../../../ui/Button';
import Input from '../../../../ui/Input';
import { reducer, initialState, actionTypes } from './reducer';
import { Icon } from 'antd';
import { registerProductCode } from '../../api';

interface IAddCode {
    mail: string;
    loyaltyId: number | boolean;
    close: () => void;
}

const firstStepStyle = {
    btn: {
        width: 200,
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

const secondStepStyle = {
    btn: {
        width: 100,
        marginTop: 40,
    },
    text: {
        marginTop: 40,
    },
    secondText: {
        marginBottom: 20,
    },
};

const AddCode = ({ mail, loyaltyId, close = () => {} }: IAddCode) => {
    const [{ step, code, isLoading, error }, dispatch] = React.useReducer(reducer, initialState);

    const handleToStepTwo = () => {
        dispatch({ type: actionTypes.FETCH });
        registerProductCode(code, loyaltyId)
            .then(response => {
                if (response.errors) {
                    response.errors.code &&
                        dispatch({
                            type: actionTypes.FETCH_FAILURE,
                            payload: response.errors.code[0],
                        });
                } else if (response.message) {
                    dispatch({
                        type: actionTypes.FETCH_FAILURE,
                        payload: response.message,
                    });
                } else {
                    dispatch({ type: actionTypes.FETCH_SUCCESS });
                }
            })
            .catch(err => {});
    };
    const handleChangeCode = e => dispatch({ type: actionTypes.SET_CODE, payload: e.target.value });

    const handleComplete = () => close();

    return (
        <div className="loyality-modal--wrapper">
            {step === 1 && (
                <React.Fragment>
                    <h3>Регистрируйте промокоды или серийные номера Wi-Fi шлюзов и получайте баллы</h3>

                    <Input onChange={handleChangeCode} value={code} placeholder="" label="" />
                    {error && <span className="loyality-modal-errors">{error}</span>}
                    <Button
                        onClick={handleToStepTwo}
                        value={
                            isLoading ? (
                                <React.Fragment>
                                    Зарегистрировать <Icon type="loading" style={firstStepStyle.icon} />
                                </React.Fragment>
                            ) : (
                                'Зарегистрировать'
                            )
                        }
                        style={firstStepStyle.btn}
                    />
                </React.Fragment>
            )}
            {step === 2 && (
                <React.Fragment>
                    <h3>Спасибо!</h3>

                    <div style={secondStepStyle.text}>
                        <div style={secondStepStyle.secondText}>Ваша заявка находится на модерации</div>
                        После прохождения модерации на <br />
                        <strong>{mail}</strong> <br /> придет уведомление.
                    </div>

                    <Button onClick={handleComplete} value="Понятно" style={secondStepStyle.btn} />
                </React.Fragment>
            )}
        </div>
    );
};

export default AddCode;
