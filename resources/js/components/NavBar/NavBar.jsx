"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var React = require("react");
var antd_1 = require("antd");
var classnames_1 = require("classnames");
var api_1 = require("./api");
var UploadSpec_1 = require("../UploadSpec");
var SelectionAnalog_1 = require("../SelectionAnalog");
var AuthRegister_1 = require("../AuthRegister");
var Icons_1 = require("../../ui/Icons/Icons");
var SubMenu = antd_1.Menu.SubMenu;
var menuItemStyle = {
    background: 'white',
};
var submenuBtnStyle = {
    padding: 0,
};
var linkStyle = {
    paddingLeft: 7,
};
var EAuthRegister;
(function (EAuthRegister) {
    EAuthRegister[EAuthRegister["Auth"] = 1] = "Auth";
    EAuthRegister[EAuthRegister["Register"] = 2] = "Register";
})(EAuthRegister || (EAuthRegister = {}));
var EOrientation;
(function (EOrientation) {
    EOrientation[EOrientation["Horizontal"] = 1] = "Horizontal";
    EOrientation[EOrientation["Vertical"] = 2] = "Vertical";
})(EOrientation || (EOrientation = {}));
var NavBar = function (props) {
    var _a = React.useState(), width = _a[0], setWidth = _a[1];
    var _b = React.useState(false), isVisible = _b[0], setMenuVisibility = _b[1];
    var _c = React.useState(false), uploadSpecIsOpen = _c[0], setUploadSpecVisibility = _c[1];
    var _d = React.useState(false), analogSelectIsOpen = _d[0], setAnalogSelectVisibility = _d[1];
    var _e = React.useState(false), authModalIsOpen = _e[0], setAuthModalIsOpen = _e[1];
    var _f = React.useState(EOrientation.Horizontal), orientation = _f[0], setOrientation = _f[1];
    // key = 1 Auth
    // key = 2 Register
    var _g = React.useState(EAuthRegister.Auth), authOrRegister = _g[0], setAuthOrRegister = _g[1];
    var isLogined = props.userResource && !Array.isArray(props.userResource);
    var resizeWindow = React.useCallback(function () {
        setWidth(window.innerWidth);
    }, []);
    React.useEffect(function () {
        window.addEventListener('resize', resizeWindow);
        return function () {
            window.removeEventListener('resize', resizeWindow);
        };
    }, []);
    React.useEffect(function () {
        resizeWindow();
        setOrientation(width >= 991 ? EOrientation.Horizontal : EOrientation.Vertical);
    }, [width]);
    React.useEffect(function () {
        if (props.openRegModal && !isLogined) {
            setAuthOrRegister(EAuthRegister.Register);
            setAuthModalIsOpen(true);
        }
    }, [props.openRegModal, isLogined]);
    var toggleVisibility = function () { return setMenuVisibility(!isVisible); };
    var handleCreateProject = function () {
        var base_url = window.location.origin;
        api_1.createProject().then(function (response) {
            document.location.href = base_url + '/project/update/' + response.data.id;
        });
    };
    var handleLogout = function () {
        var base_url = window.location.origin;
        api_1.logout(props.csrf).then(function (response) {
            document.location.href = base_url;
        });
    };
    var handleOpenUploadSpec = function () { return setUploadSpecVisibility(true); };
    var handleCloseUploadSpec = function () { return setUploadSpecVisibility(false); };
    var handleOpenAnalogSelect = function () { return setAnalogSelectVisibility(true); };
    var handleCloseAnalogSelect = function () { return setAnalogSelectVisibility(false); };
    var handleOpenAuthModal = function () {
        setAuthOrRegister(EAuthRegister.Auth);
        setAuthModalIsOpen(true);
    };
    var handleColseAuthModal = function () { return setAuthModalIsOpen(false); };
    var handleOpenRegisterModal = function () {
        setAuthOrRegister(EAuthRegister.Register);
        setAuthModalIsOpen(true);
    };
    var isVertical = orientation === EOrientation.Vertical;
    var handleLogoLink = function (e) {
        if (typeof window !== 'undefined') {
            window.location.pathname === '/' && e.preventDefault();
        }
    };
    return (<div className={classnames_1.default('navbar-wrapper', {
        'vertical-orientation': isVertical,
    })}>
            <div className="container">
                <nav className={classnames_1.default('legrand-navbar', {
        'vertical-orientation': isVertical,
    })}>
                    <div className="navbar-logo-wrapper">
                        <a className="navbar-brand " href="/" onClick={handleLogoLink}>
                            {Icons_1.superElectricianLogo}
                        </a>
                    </div>

                    {orientation === EOrientation.Vertical && (<antd_1.Icon type="menu" onClick={toggleVisibility} className="menu-colapse-icon"/>)}

                    {(orientation === EOrientation.Horizontal || isVisible) && (<antd_1.Menu mode={orientation === EOrientation.Horizontal ? 'horizontal' : 'inline'}>
                            <antd_1.Menu.Item key="projects">
                                <a href="/project/list">Мои проекты</a>
                            </antd_1.Menu.Item>
                            <SubMenu key="tools" title={<span className="with-icon-title-wrapper">
                                        Инструменты
                                        <antd_1.Icon type="down"/>
                                    </span>}>
                                {isLogined && (<antd_1.Menu.Item key="setting:1" className="menu-subitem" style={menuItemStyle}>
                                        <button onClick={handleOpenUploadSpec} style={submenuBtnStyle}>
                                            Загрузить спецификацию
                                        </button>
                                    </antd_1.Menu.Item>)}

                                <antd_1.Menu.Item key="setting:2" className="menu-subitem" style={menuItemStyle}>
                                    <button onClick={handleOpenAnalogSelect} style={submenuBtnStyle}>
                                        Подбор аналогов
                                    </button>
                                </antd_1.Menu.Item>
                            </SubMenu>
                            <antd_1.Menu.Item key="catalog">
                                <a href="/catalog">Каталог</a>
                            </antd_1.Menu.Item>
                            <antd_1.Menu.Item key="where_to_buy">
                                <a href="https://legrand.ru/where/map" target="_blank">
                                    Где купить
                                </a>
                            </antd_1.Menu.Item>
                            <SubMenu key="blog" title={<span className="with-icon-title-wrapper">
                                        Блог
                                        <antd_1.Icon type="down"/>
                                    </span>}>
                                <antd_1.Menu.Item key="setting:7" className="menu-subitem" style={menuItemStyle}>
                                    <a href="/news" className="legweb-text-btn">
                                        Новости
                                    </a>
                                </antd_1.Menu.Item>

                                <antd_1.Menu.Item key="setting:6" className="menu-subitem" style={menuItemStyle}>
                                    <a href="/video" className="legweb-text-btn">
                                        Видео
                                    </a>
                                </antd_1.Menu.Item>

                                <antd_1.Menu.Item key="setting:9" className="menu-subitem" style={menuItemStyle}>
                                    <a href="/test" className="legweb-text-btn">
                                        Тесты
                                    </a>
                                </antd_1.Menu.Item>
                                <antd_1.Menu.Item key="setting:8" className="menu-subitem" style={menuItemStyle}>
                                    <a href="https://legrand.ru/services/learning" target="_blank" className="legweb-text-btn">
                                        Записаться на обучение
                                    </a>
                                </antd_1.Menu.Item>
                            </SubMenu>
                            <antd_1.Menu.Item key="help">
                                <a href="/faq">Помощь</a>
                            </antd_1.Menu.Item>

                            {isLogined
        ? [
            <SubMenu key="user-menu" title={<span className="with-icon-title-wrapper">
                                                  <div className="navbar-name-wrapper">
                                                      {props.userResource.first_name}
                                                  </div>
                                                  <antd_1.Icon type="down"/>
                                              </span>}>
                                          <antd_1.Menu.Item key="setting:3" className="menu-subitem" style={menuItemStyle}>
                                              <a href="/user/profile" style={linkStyle} className="navbar-link">
                                                  Мой профиль
                                              </a>
                                          </antd_1.Menu.Item>
                                          {<antd_1.Menu.Item key="setting:4" className="menu-subitem" style={menuItemStyle}>
                                                  <a href="/loyalty-program" style={linkStyle} className="navbar-link">
                                                      Программа лояльности
                                                  </a>
                                              </antd_1.Menu.Item>}
                                          
                                          <antd_1.Menu.Item key="setting:6" className="menu-subitem" style={menuItemStyle}>
                                              <button onClick={handleLogout}>Выйти</button>
                                          </antd_1.Menu.Item>
                                      </SubMenu>,
        ]
        : [
            <antd_1.Menu.Item key="login" style={menuItemStyle}>
                                          <button className="legrand-btn btn-second " onClick={handleOpenAuthModal}>
                                              Войти
                                          </button>
                                      </antd_1.Menu.Item>,
            <antd_1.Menu.Item key="register" style={menuItemStyle}>
                                          <button className="legrand-btn btn-accent " onClick={handleOpenRegisterModal}>
                                              Регистрация
                                          </button>
                                      </antd_1.Menu.Item>,
        ]}
                            {isLogined && props.userResource.roles.find(function (el) { return el.slug === 'electrician'; }) && (<antd_1.Menu.Item key="create-project" style={menuItemStyle}>
                                    <button onClick={handleCreateProject} className="legrand-btn btn-accent">
                                        Создать проект
                                    </button>
                                </antd_1.Menu.Item>)}
                        </antd_1.Menu>)}
                </nav>

                {uploadSpecIsOpen && <UploadSpec_1.default onClose={handleCloseUploadSpec} isOpen={uploadSpecIsOpen}/>}

                {analogSelectIsOpen && (<SelectionAnalog_1.default onClose={handleCloseAnalogSelect} isOpen={analogSelectIsOpen} user={props.userResource}/>)}
                {authModalIsOpen && (<AuthRegister_1.default isOpen={authModalIsOpen} onClose={handleColseAuthModal} defaultTab={authOrRegister}/>)}
            </div>
        </div>);
};
exports.default = NavBar;
