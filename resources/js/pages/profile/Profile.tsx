import * as React from 'react';
import { IProfile } from './types';
import PageLayout from '../../components/PageLayout';
import Input from '../../ui/Input';
import Button from '../../ui/Button';
import CheckBox from '../../ui/Checkbox';
import PhoneInput from '../../ui/PhoneInput';
import Modal from '../../ui/Modal';
import { Icon, notification } from 'antd';
import { saveProfileSettings, updatePAssword, uploadPhoto, removeUser } from './api';
import CityInput from '../../ui/CityInput';
// import Publication from './publication/Publication';
import Participate from '../loyality/components/Participate/Participate';

// const btnStyle = {
//     marginBottom: 20,
//     marginTop: 20,
//     fontSize: 12,
// };
interface IState {
    firstName: string;
    lastName: string;
    city: string;
    phone: string;
    email: string;
    personalSite: string;
    emailSubscription: boolean;
    currentPassword: string;
    newPassword: string;
    confirmPassword: string;
    saveUserRequest: boolean;
    errors: any;
    passwordUpdateRequest: boolean;
    passwordErrors: any;
    city_id: number;
    photo: string | boolean;
    photoName: string;
    photoError: boolean | string;
    deleteModalIsOpen: boolean;
    participateModalIsOpen: boolean;
}

type StateKeys = keyof IState;

class Home extends React.Component<IProfile, IState> {
    state = {
        firstName: this.props.store.user.first_name,
        lastName: this.props.store.user.last_name,
        personalSite: this.props.store.user.personal_site !== null ? this.props.store.user.personal_site : '',
        emailSubscription: this.props.store.user.email_subscription,
        city: this.props.store.user.city_id !== null ? this.props.store.user.city : null,
        phone: this.props.store.user.phone,
        email: this.props.store.user.email,
        currentPassword: '',
        newPassword: '',
        confirmPassword: '',
        saveUserRequest: false,
        errors: false,
        passwordUpdateRequest: false,
        passwordErrors: false,
        city_id: this.props.store.user.city_id,
        photo: this.props.store.userResource.photo === '' ? false : this.props.store.userResource.photo,
        photoName: '',
        photoError: false,
        deleteModalIsOpen: false,
        participateModalIsOpen: false,
    };

    fileInput = React.createRef<HTMLInputElement>();

    openNotificationWithIcon = (type, description) => {
        notification[type]({
            message: 'Изменение учетной записи',
            description,
        });
    };

    handleSaveProfileSettings = () => {
        const { firstName, lastName, personalSite, emailSubscription, city_id, phone } = this.state;
        this.setState({ saveUserRequest: true, errors: false });

        const params: any = {
            first_name: firstName,
            last_name: lastName,
            personal_site: personalSite,
            email_subscription: emailSubscription,
            city_id,
            phone,
        };

        saveProfileSettings(params)
            .then(response => {
                if (response.errors) {
                    this.setState({ errors: response.errors });
                    throw new Error(response.message);
                }
                this.openNotificationWithIcon('success', 'Данные учетной записи успешно обновлены');
                this.setState({ saveUserRequest: false });
                location.reload();
            })
            .catch(err => {
                this.openNotificationWithIcon('error', err.message);
                this.setState({ saveUserRequest: false });
            });
    };

    handleUpdatePassword = () => {
        const { currentPassword, newPassword, confirmPassword } = this.state;

        this.setState({ passwordUpdateRequest: true, passwordErrors: false });

        const params = {
            current_password: currentPassword,
            new_password: newPassword,
            new_password_confirmation: confirmPassword,
        };

        updatePAssword(params)
            .then(response => {
                if (response.errors) {
                    this.setState({ passwordErrors: response.errors });
                    throw new Error(response.message);
                } else {
                    this.openNotificationWithIcon('success', 'Пароль успешно изменен');
                    this.setState({ passwordUpdateRequest: false });
                    location.reload();
                }
            })
            .catch(err => {
                this.openNotificationWithIcon('error', err.message);
                this.setState({ passwordUpdateRequest: false });
            });
    };

    handleChangeInput = e => {
        const key: StateKeys = e.target.name;
        const value = e.target.value;

        this.setState({
            [key]: value,
        } as Pick<IState, keyof IState>);
    };

    handleChangePhone = value => {
        this.setState({ phone: value });
    };

    handleChangeEmailSubscription = value => {
        this.setState({ emailSubscription: value });
    };

    handleSelectCity = value => {
        this.setState({ city_id: value.id });
    };

    handleSelectPhoto = () => {
        this.setState({ photoName: this.fileInput.current.files[0].name, photoError: false });
    };

    handleUploadPhoto = e => {
        e.preventDefault();
        const file = this.fileInput.current.files[0];
        uploadPhoto({ file })
            .then(response => {
                if (response.errors) {
                    throw new Error(response.errors.photo[0]);
                } else {
                    document.location.reload();
                }
            })
            .catch(err => {
                this.setState({ photoError: err.message });
            });
    };

    handleDeleteUserModalOpen = () => this.setState({ deleteModalIsOpen: true });
    handleDeleteUserModalClose = () => this.setState({ deleteModalIsOpen: false });

    handleDeleteUserAccount = () =>
        removeUser()
            .then(response => document.location.reload())
            .catch(err => {});

    render() {
        const {
            firstName,
            lastName,
            personalSite,
            emailSubscription,
            city,
            phone,
            email,
            currentPassword,
            newPassword,
            confirmPassword,
            saveUserRequest,
            passwordUpdateRequest,
            errors,
            passwordErrors,
            photoName,
            photo,
            photoError,
            deleteModalIsOpen,
            participateModalIsOpen,
        } = this.state;

        const checkPassword =
            currentPassword === '' || newPassword === '' || confirmPassword === '' || confirmPassword !== newPassword;
        return (
            <div className="container mt-4 mb-3 profile-wrapper" key="container">
                {participateModalIsOpen && (
                    <Modal
                        isOpen={participateModalIsOpen}
                        onClose={() => this.setState({ participateModalIsOpen: false })}
                    >
                        <Participate close={() => this.setState({ participateModalIsOpen: false })} />
                    </Modal>
                )}
                {deleteModalIsOpen && (
                    <Modal isOpen={deleteModalIsOpen} onClose={this.handleDeleteUserModalClose}>
                        <h5>Удалить личный кабинет?</h5>
                        <p>После удаления личного кабинеты вы больше не сможете его восстановить</p>
                        <div className="remove-btns-wrapper">
                            <Button value="Удалить" appearance="second" onClick={this.handleDeleteUserAccount} />
                            <Button value="Отмена" appearance="accent" onClick={this.handleDeleteUserModalClose} />
                        </div>
                    </Modal>
                )}
                <div className="row ">
                    <div className="col-md-12">
                        <h1>Мой профиль</h1>
                    </div>
                </div>

                <div className="row">
                    <div className="col-lg-8">
                        <div className="loyality-info-wrapper">
                            Вы можете принять участие в нашей программе лояльности и получать статусные подарки за
                            достижение уровней. <a href="/leto_legrand">Перейти</a>
                        </div>
                    </div>
                </div>

                {/*<div className="row">*/}
                {/*    <div className="col-lg-8">*/}
                {/*        {this.props.store.user.certificates.length ? (*/}
                {/*            <Publication user={this.props.store.user} />*/}
                {/*        ) : (*/}
                {/*            <Button*/}
                {/*                onClick={() => this.setState({ participateModalIsOpen: true })}*/}
                {/*                value="Зарегистрировать сертификат"*/}
                {/*                appearance="accent"*/}
                {/*                style={btnStyle}*/}
                {/*            />*/}
                {/*        )}*/}
                {/*    </div>*/}
                {/*</div>*/}

                <div className="row profile-photo-row">
                    <div className="col-12">
                        <div className="profile-photo">
                            {photo && <img src={photo} className="profile-user-photo" />}
                            <form onSubmit={this.handleUploadPhoto}>
                                <label className="profile-photo-label">
                                    <Icon type="link" /> {photoName !== '' ? photoName : 'Загрузить фото'}
                                    <input
                                        type="file"
                                        className="profile-photo-input"
                                        ref={this.fileInput}
                                        onChange={this.handleSelectPhoto}
                                    />
                                </label>
                                <br />
                                {photoError && <span className="profile-photo-error">{photoError}</span>}
                                {photoName !== '' && (
                                    <Button type="submit" value="Загрузить" appearance="accent" className="mb-3" />
                                )}
                            </form>
                        </div>
                    </div>
                </div>
                <div className="row profile-section">
                    <div className="col-lg-8">
                        <h3>Персональные данные</h3>
                    </div>
                </div>
                <div className="row mt-2">
                    <div className="col-md-4">
                        <Input
                            onChange={this.handleChangeInput}
                            value={firstName}
                            placeholder="Имя"
                            label="Имя"
                            name="firstName"
                        />
                    </div>
                    <div className="col-md-4">
                        <Input
                            onChange={this.handleChangeInput}
                            value={lastName}
                            placeholder="Фамилия"
                            label="Фамилия"
                            name="lastName"
                        />
                    </div>
                </div>
                <div className="row mt-2">
                    <div className="col-md-4">
                        <CityInput onSelect={this.handleSelectCity} defaultValue={city} />
                    </div>
                </div>
                <div className="row mt-2">
                    <div className="col-md-4">
                        <PhoneInput defaultCountry={'ru'} value={phone} onChange={this.handleChangePhone} />
                    </div>
                    <div className="col-md-4">
                        <Input
                            onChange={this.handleChangeInput}
                            value={email}
                            placeholder="E-mail"
                            label="E-mail"
                            name="email"
                            disabled
                        />
                    </div>
                </div>
                <div className="row mt-2">
                    <div className="col-md-4">
                        <Input
                            onChange={this.handleChangeInput}
                            value={personalSite}
                            placeholder="http://example.com/"
                            label="Сайт или страница в соц. сетях"
                            name="personalSite"
                        />
                    </div>
                </div>
                <div className="row mt-3">
                    <div className="col-md-4">
                        <CheckBox
                            checked={emailSubscription}
                            onChange={this.handleChangeEmailSubscription}
                            label={
                                <span>
                                    <a
                                        className="legrand-text-btn"
                                        href="/сonsent_to_receive_promotional_mailings.pdf"
                                        target="_blank"
                                    >
                                        Cогласен&nbsp;
                                    </a>
                                    получать рассылки на эл.почту
                                </span>
                            }
                            name="emailSubscription"
                        />
                    </div>
                </div>
                {errors && (
                    <div className="row">
                        <div className="profile-update-errors col-lg-8">
                            {Object.keys(errors).map((key: any) =>
                                errors[key].map(el => (
                                    <span className="profile-update-error" key={el}>
                                        {el}
                                    </span>
                                )),
                            )}
                        </div>
                    </div>
                )}
                <div className="row mt-3">
                    <div className="col-md-4">
                        <Button
                            onClick={this.handleSaveProfileSettings}
                            value={
                                saveUserRequest ? (
                                    <React.Fragment>
                                        Сохранить изменения <Icon type="loading" />
                                    </React.Fragment>
                                ) : (
                                    'Сохранить изменения'
                                )
                            }
                        />
                    </div>
                </div>

                <div className="row profile-section">
                    <div className="col-lg-8">
                        <h3>Персональные данные</h3>
                    </div>
                </div>

                <div className="row mt-2">
                    <div className="col-md-4">
                        <Input
                            onChange={this.handleChangeInput}
                            value={currentPassword}
                            placeholder="Текущий пароль"
                            name="currentPassword"
                            label="Старый пароль"
                            isPassword
                            autoComplete="off"
                        />
                    </div>
                </div>
                <div className="row mt-2">
                    <div className="col-md-4">
                        <Input
                            onChange={this.handleChangeInput}
                            value={newPassword}
                            placeholder="Новый пароль"
                            label="Новый пароль"
                            name="newPassword"
                            isPassword
                            autoComplete="off"
                        />
                    </div>
                    <div className="col-md-4">
                        <Input
                            onChange={this.handleChangeInput}
                            value={confirmPassword}
                            placeholder="Подтвердите пароль"
                            name="confirmPassword"
                            label="Подтвердите пароль"
                            isPassword
                            autoComplete="off"
                        />
                    </div>
                </div>
                {passwordErrors && (
                    <div className="row">
                        <div className="profile-update-errors col-lg-8">
                            {Object.keys(passwordErrors).map((key: any) =>
                                passwordErrors[key].map(el => (
                                    <span className="profile-update-error" key={el}>
                                        {el}
                                    </span>
                                )),
                            )}
                        </div>
                    </div>
                )}
                <div className="row mt-3">
                    <div className="col-md-4">
                        <Button
                            onClick={this.handleUpdatePassword}
                            value={
                                passwordUpdateRequest ? (
                                    <React.Fragment>
                                        Сменить пароль <Icon type="loading" />
                                    </React.Fragment>
                                ) : (
                                    'Сменить пароль'
                                )
                            }
                            disabled={checkPassword}
                        />
                    </div>
                </div>

                <div className="row remove-account-row">
                    <div className="col-12">
                        <button className="legrand-text-btn" onClick={this.handleDeleteUserModalOpen}>
                            Удалить личный кабинет
                        </button>
                    </div>
                </div>
            </div>
        );
    }
}

export default PageLayout(Home);
