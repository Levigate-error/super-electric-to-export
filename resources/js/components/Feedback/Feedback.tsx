import * as React from 'react';
import { reducer, initialState, actionTypes } from './reducer';
import { sendFeedback } from './api';
import { Modal } from 'antd';
import Button from '../../ui/Button';
import Input from '../../ui/Input';
import TextArea from '../../ui/TextArea';
import { closeIcon } from '../../ui/Icons/Icons';
import { Icon } from 'antd';
import { UserContext } from '../PageLayout/PageLayout';
import Captcha from './Captcha';

interface IFeedback {
    isOpen: boolean;
    type: string; // Тип. Может быть common и help. help - когда со страницы помощь. common - когда из футера.
    onClose: () => void;
}

const Feedback = ({ isOpen, type, onClose }: IFeedback) => {
    const userCtx = React.useContext(UserContext);

    const [
        {
            isLoading,
            name,
            email,
            message,
            file,
            captcha,
            nameError,
            emailError,
            messageError,
            fileError,
            capthcaError,
            needVeryfy,
            success,
        },
        dispatch,
    ] = React.useReducer(reducer, initialState);

    const handleSendForm = () => {
        dispatch({ type: actionTypes.SEND_FORM });
        const params = {
            name,
            email,
            text: message,
            type,
            captcha,
        };

        sendFeedback(params, file)
            .then(response => {
                dispatch({ type: actionTypes.SEND_SUCCESS });
            })
            .catch(error => {
                if (error.response && error.response.data) {
                    const { errors } = error.response.data;

                    errors['name'] && dispatch({ type: actionTypes.SET_NAME_ERROR, payload: errors['name'][0] });
                    errors['email'] && dispatch({ type: actionTypes.SET_EMAIL_ERROR, payload: errors['email'][0] });
                    errors['message'] &&
                        dispatch({ type: actionTypes.SET_MESSAGE_ERROR, payload: errors['message'][0] });
                    errors['file'] && dispatch({ type: actionTypes.SET_FILE_ERROR, payload: errors['file'][0] });
                    errors['g-recaptcha-response'] &&
                        dispatch({ type: actionTypes.SET_CAPTHA_ERROR, payload: errors['g-recaptcha-response'][0] });
                }
            });
    };

    const handleVerifyCapthca = token => {
        if (typeof token === 'string') {
            dispatch({ type: actionTypes.SET_CAPTCHA, payload: token });
        }
    };

    const handleSetName = e => {
        const value = e.target.value;
        dispatch({ type: actionTypes.SET_NAME, payload: value });
    };

    const handleSetEmail = e => {
        const value = e.target.value;
        dispatch({ type: actionTypes.SET_EMAIL, payload: value });
    };

    const handleSetMessage = e => {
        const value = e.target.value;

        dispatch({ type: actionTypes.SET_MESSAGE, payload: message.length >= 1000 ? value.substring(0, 1000) : value });
    };

    const handleSetFile = (e: any) => {
        const target = event.target as HTMLInputElement;
        const file: File = (target.files as FileList)[0];
        dispatch({ type: actionTypes.SET_FILE, payload: file });
    };

    const submitDisabled = isLoading || name === '' || message === '' || email === '';

    const error = nameError || emailError || messageError || fileError || capthcaError;

    return (
        <Modal visible={isOpen} onCancel={onClose} closeIcon={closeIcon} footer={false}>
            <div className="feedback-modal-wrapper">
                {success ? (
                    <React.Fragment>
                        <h1 className="feedback-success-header">Ваше сообщение отправлено.</h1>
                        <div className="feedback-success-info">
                            Мы ответим вам в ближайшее время! Спасибо за обращение, вместе мы сделаем сервис лучше.
                        </div>
                    </React.Fragment>
                ) : (
                    <React.Fragment>
                        <h1 className="feedback-modal-title">Написать нам</h1>
                        <Input
                            value={name}
                            onChange={handleSetName}
                            error={nameError}
                            placeholder="Ваше имя"
                            label="Как к вам обращаться"
                        />
                        <Input
                            value={email}
                            error={emailError}
                            onChange={handleSetEmail}
                            placeholder="email@"
                            label="Укажите адрес электронной почты для получения ответа"
                        />
                        <TextArea
                            error={messageError}
                            value={message}
                            label={`Текст сообщения ${message.length}/1000`}
                            rows={4}
                            onChange={handleSetMessage}
                            maxLength={1000}
                        />
                        <label htmlFor="upload-file-input" className="upload-file-input-wrapper">
                            <Icon type="paper-clip" className="file-template-i" />
                            {file ? file.name : 'Прикрепить файл'}
                        </label>
                        {fileError && <span className="feedback-error-wrapper">{fileError}</span>}
                        {capthcaError && <span className="feedback-error-wrapper">{capthcaError}</span>}
                        <input
                            id="upload-file-input"
                            className="upload-file-input"
                            type="file"
                            onChange={handleSetFile}
                        />
                        {needVeryfy && (
                            <div className="feedback-recapthca-wrapper">
                                <Captcha sitekey={userCtx.recaptcha || 'sitekey'} onVerify={handleVerifyCapthca} />
                            </div>
                        )}
                        <Button
                            onClick={handleSendForm}
                            value="Отправить"
                            isLoading={isLoading}
                            disabled={submitDisabled || error}
                            appearance="accent"
                            className="feedback-submit-btn"
                        />
                    </React.Fragment>
                )}
            </div>
        </Modal>
    );
};

export default Feedback;
