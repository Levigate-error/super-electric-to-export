import * as React from 'react';
import { Menu, Icon } from 'antd';
import classnames from 'classnames';
import { createProject, logout } from './api';
import UploadSpec from '../UploadSpec';
import AnalogSelect from '../SelectionAnalog';
import AuthRegister from '../AuthRegister';
import { superElectricianLogo } from '../../ui/Icons/Icons';
import eventBus from "../../utils/eventBus";
const { SubMenu } = Menu;

const menuItemStyle = {
    background: 'white',
};

const submenuBtnStyle = {
    padding: 0,
};

const linkStyle = {
    paddingLeft: 7,
};

enum EAuthRegister {
    Auth = 1,
    Register = 2,
}

enum EOrientation {
    Horizontal = 1,
    Vertical = 2,
}

const NavBar = props => {
    const [width, setWidth] = React.useState("0");
    const [isVisible, setMenuVisibility] = React.useState(false);
    const [uploadSpecIsOpen, setUploadSpecVisibility] = React.useState(false);
    const [analogSelectIsOpen, setAnalogSelectVisibility] = React.useState(false);
    const [authModalIsOpen, setAuthModalIsOpen] = React.useState(false);
    const [orientation, setOrientation] = React.useState(EOrientation.Horizontal);

    // key = 1 Auth
    // key = 2 Register
    const [authOrRegister, setAuthOrRegister] = React.useState(EAuthRegister.Auth);

    const isLogined = props.userResource && !Array.isArray(props.userResource);

    const resizeWindow = React.useCallback(() => {
        setWidth(window.innerWidth as any);
    }, []);

    React.useEffect(() => {
        const onOpenRegister = () => {
          handleOpenRegisterModal()
        }

        eventBus.on('open-register', onOpenRegister)
        window.addEventListener('resize', resizeWindow);
        return () => {
            eventBus.remove('open-register', onOpenRegister)
            window.removeEventListener('resize', resizeWindow);
        };
    }, []);

    React.useEffect(() => {
        resizeWindow();
        setOrientation(parseInt(width) >= 991 ? EOrientation.Horizontal : EOrientation.Vertical);
    }, [width]);

    React.useEffect(() => {
        if (props.openRegModal && !isLogined) {
            setAuthOrRegister(EAuthRegister.Register);
            setAuthModalIsOpen(true);
        }
    }, [props.openRegModal, isLogined]);

    const toggleVisibility = () => setMenuVisibility(!isVisible);

    const handleCreateProject = () => {
        const base_url = window.location.origin;
        createProject().then(response => {
            document.location.href = base_url + '/project/update/' + response.data.id;
        });
    };

    const handleLogout = () => {
        const base_url = window.location.origin;

        logout(props.csrf).then(response => {
            document.location.href = base_url;
        });
    };

    const handleOpenUploadSpec = () => setUploadSpecVisibility(true);
    const handleCloseUploadSpec = () => setUploadSpecVisibility(false);

    const handleOpenAnalogSelect = () => setAnalogSelectVisibility(true);
    const handleCloseAnalogSelect = () => setAnalogSelectVisibility(false);

    const handleOpenAuthModal = () => {
        setAuthOrRegister(EAuthRegister.Auth);
        setAuthModalIsOpen(true);
    };

    const handleColseAuthModal = () => setAuthModalIsOpen(false);

    const handleOpenRegisterModal = () => {
        setAuthOrRegister(EAuthRegister.Register);
        setAuthModalIsOpen(true);
    };

    const isVertical = orientation === EOrientation.Vertical;


    const handleLogoLink = e => {
        if (typeof window !== 'undefined') {
            window.location.pathname === '/' && e.preventDefault();
        }
    };

    return (
        <div
            className={classnames('navbar-wrapper', {
                'vertical-orientation': isVertical,
            })}
        >
            <div className="container">

            </div>

            <div className="container">
                <nav
                    className={classnames('legrand-navbar', {
                        'vertical-orientation': isVertical,
                    })}
                >
                    <div className="navbar-logo-wrapper">
                        <a className="navbar-brand " href="/" onClick={handleLogoLink}>
                            {superElectricianLogo}
                        </a>
                    </div>

                    {orientation === EOrientation.Vertical && (
                        <Icon type="menu" onClick={toggleVisibility} className="menu-colapse-icon" />
                    )}

                    {(orientation === EOrientation.Horizontal || isVisible) && (
                        <Menu mode={orientation === EOrientation.Horizontal ? 'horizontal' : 'inline'}>
                            <Menu.Item key="projects">
                                <a href="/project/list">Мои проекты</a>
                            </Menu.Item>
                            <SubMenu
                                key="tools"
                                title={
                                    <span className="with-icon-title-wrapper">
                                        Инструменты
                                        <Icon type="down" />
                                    </span>
                                }
                            >
                                {isLogined && (
                                    <Menu.Item key="setting:1" className="menu-subitem" style={menuItemStyle}>
                                        <button onClick={handleOpenUploadSpec} style={submenuBtnStyle}>
                                            Загрузить спецификацию
                                        </button>
                                    </Menu.Item>
                                )}

                                <Menu.Item key="setting:2" className="menu-subitem" style={menuItemStyle}>
                                    <button onClick={handleOpenAnalogSelect} style={submenuBtnStyle}>
                                        Подбор аналогов
                                    </button>
                                </Menu.Item>
                            </SubMenu>
                            <Menu.Item key="catalog">
                                <a href="/catalog">Каталог</a>
                            </Menu.Item>
                            <Menu.Item key="where_to_buy">
                                <a href="https://legrand.ru/where/map" target="_blank">
                                    Где купить
                                </a>
                            </Menu.Item>
                            <SubMenu
                                key="blog"
                                title={
                                    <span className="with-icon-title-wrapper">
                                        Блог
                                        <Icon type="down" />
                                    </span>
                                }
                            >
                                <Menu.Item key="setting:7" className="menu-subitem" style={menuItemStyle}>
                                    <a href="/news" className="legweb-text-btn">
                                        Новости
                                    </a>
                                </Menu.Item>

                                <Menu.Item key="setting:6" className="menu-subitem" style={menuItemStyle}>
                                    <a href="/video" className="legweb-text-btn">
                                        Видео
                                    </a>
                                </Menu.Item>

                                <Menu.Item key="setting:8" className="menu-subitem" style={menuItemStyle}>
                                    <a
                                        href="https://legrand.ru/services/learning"
                                        target="_blank"
                                        className="legweb-text-btn"
                                    >
                                        Записаться на обучение
                                    </a>
                                </Menu.Item>
                            </SubMenu>
                            <Menu.Item key="help">
                                <a href="/faq">Помощь</a>
                            </Menu.Item>

                            {isLogined
                                ? [
                                      <SubMenu
                                          key="user-menu"
                                          title={
                                              <span className="with-icon-title-wrapper">
                                                  <div className="navbar-name-wrapper">
                                                      {props.userResource.first_name}
                                                  </div>
                                                  <Icon type="down" />
                                              </span>
                                          }
                                      >
                                          <Menu.Item key="setting:3" className="menu-subitem" style={menuItemStyle}>
                                              <a href="/user/profile" style={linkStyle} className="navbar-link">
                                                  Мой профиль
                                              </a>
                                          </Menu.Item>
                                          {
                                              <Menu.Item key="setting:4" className="menu-subitem" style={menuItemStyle}>
                                                  <a href="/loyalty-program" style={linkStyle} className="navbar-link">
                                                      Программа лояльности Netatmo
                                                  </a>
                                              </Menu.Item>
                                          }
                                          {/*<Menu.Item key="setting:5" className="menu-subitem" style={menuItemStyle}>*/}
                                          {/*    <a href="/leto_legrand" style={linkStyle} className="navbar-link">*/}
                                          {/*        Программа лояльности*/}
                                          {/*    </a>*/}
                                          {/*</Menu.Item>*/}
                                          <Menu.Item key="setting:5" className="menu-subitem" style={menuItemStyle}>
                                              <button onClick={handleLogout}>Выйти</button>
                                          </Menu.Item>
                                      </SubMenu>,
                                  ]
                                : [
                                      <Menu.Item key="login" style={menuItemStyle}>
                                          <button className="legrand-btn btn-second " onClick={handleOpenAuthModal}>
                                              Войти
                                          </button>
                                      </Menu.Item>,
                                      <Menu.Item key="register" style={menuItemStyle}>
                                          <button className="legrand-btn btn-accent " onClick={handleOpenRegisterModal}>
                                              Регистрация
                                          </button>
                                      </Menu.Item>,
                                  ]}
                            {isLogined && props.userResource.roles.find(el => el.slug === 'electrician') && (
                                <Menu.Item key="create-project" style={menuItemStyle}>
                                    <button onClick={handleCreateProject} className="legrand-btn btn-accent">
                                        Создать проект
                                    </button>
                                </Menu.Item>
                            )}
                        </Menu>
                    )}
                </nav>

                {uploadSpecIsOpen && <UploadSpec onClose={handleCloseUploadSpec} isOpen={uploadSpecIsOpen} />}

                {analogSelectIsOpen && (
                    <AnalogSelect
                        onClose={handleCloseAnalogSelect}
                        isOpen={analogSelectIsOpen}
                        user={props.userResource}
                    />
                )}
                {authModalIsOpen && (
                    <AuthRegister isOpen={authModalIsOpen} onClose={handleColseAuthModal} defaultTab={authOrRegister} />
                )}
            </div>
        </div>
    );
};

export default NavBar;
