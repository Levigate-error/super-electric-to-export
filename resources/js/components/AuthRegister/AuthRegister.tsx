import * as React from 'react';
import Register from './components/Register';
import Auth from './components/Auth';
import Tabs from '../../ui/Tabs';
import { Modal } from 'antd';
import { closeIcon } from '../../ui/Icons/Icons';
import Restore from './components/Restore';
import { UserContext } from '../PageLayout/PageLayout';
interface IAuthRegister {
    isOpen?: boolean;
    onClose?: () => void;
    defaultTab?: number;
    wrapped?: any;
}

const AuthRegister = ({ isOpen = false, onClose = () => {}, defaultTab = 1, wrapped }: IAuthRegister) => {
    const userCtx = React.useContext(UserContext);

    const [restorePassword, setRestorePassword] = React.useState(false);
    const [authVisibility, setAuthVisibility] = React.useState(false);

    const handleRestorePassword = () => setRestorePassword(true);

    const handleClose = () => {
        setAuthVisibility(false);
        onClose();
    };

    const handleCheckAuth = e => {
        const isAuth = !(Array.isArray(userCtx.userResource) && userCtx.userResource.length === 0);
        !isAuth && setAuthVisibility(true);
    };

    const tabs = [
        {
            key: '1',
            title: 'Авторизация',
            child: <Auth restorePassword={handleRestorePassword} csrf={userCtx.csrf} />,
        },
        {
            key: '2',
            title: 'Регистрация',
            child: <Register csrf={userCtx.csrf} />,
        },
    ];

    return (
        <React.Fragment>
            {wrapped && <span onClick={handleCheckAuth}>{wrapped}</span>}
            {(isOpen || authVisibility) && !userCtx.user && (
                <Modal visible={isOpen || authVisibility} onCancel={handleClose} closeIcon={closeIcon} footer={false}>
                    {restorePassword ? <Restore csrf={userCtx.csrf} /> : <Tabs tabs={tabs} defaultKey={defaultTab} />}
                </Modal>
            )}
        </React.Fragment>
    );
};

export default AuthRegister;
