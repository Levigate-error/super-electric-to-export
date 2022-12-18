import * as React from 'react';
import NavBar from '../NavBar';
import Breadcrumbs from '../Breadcrumbs';
import { BackTop, Icon, notification } from 'antd';
import Button from '../../ui/Button';
import Footer from '../Footer';

export const UserContext = React.createContext<any>({});

const PageLayout = WrappedComponent => {
    return props => {
        return (
            <UserContext.Provider
                value={{
                    user: props.store.user,
                    userResource: props.store.userResource,
                    csrf: props.store.csrf,
                    recaptcha: props.store.recaptcha,
                    openRegModal: props.store.openRegModal,
                }}
            >
                <div className="top-and-content-wrapper">
                    <div className="top-bar-wrapper">
                        <CookieCheck />
                        <NavBar
                            key="navbar"
                            user={props.store.user}
                            userResource={props.store.userResource}
                            userRoles={props.store.user_roles}
                            csrf={props.store.csrf}
                            openRegModal={props.store.openRegModal}
                        />
                        <Breadcrumbs key="breadcrumbs" breadcrumbs={props.store.breadcrumbs} />
                    </div>
                    <WrappedComponent {...props} key="page" />
                </div>

                <BackTop>
                    <div className="ant-back-top-inner">
                        <Icon type="to-top" />
                    </div>
                </BackTop>
                <Footer user={props.store.user} />
            </UserContext.Provider>
        );
    };
};

export default PageLayout;

const CookieCheck = () => {
    React.useEffect(() => {
        const visited = localStorage['alreadyVisited'];
        if (!visited) {
            localStorage['alreadyVisited'] = true;
            openNotification('topLeft');
        }
    }, []);

    const openNotification = placement => {
        const key = `open${Date.now()}`;
        const btn = <Button onClick={() => notification.close(key)} value="Понятно" appearance="accent" />;
        const args = {
            message: 'Использование Cookie',
            description: 'Оставаясь на сайте Вы даете согласие на использование cookies.',
            placement,
            duration: 0,
            btn,
            key,
        };
        notification.open(args);
    };

    return <div />;
};
