"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const api_1 = require("./api");
const AuthRegister_1 = require("../../../../components/AuthRegister/AuthRegister");
const PageLayout_1 = require("../../../../components/PageLayout/PageLayout");
var EBannerSize;
(function (EBannerSize) {
    EBannerSize["bs_320"] = "320x280";
    EBannerSize["bs_576"] = "576x280";
    EBannerSize["bs_768"] = "768x280";
    EBannerSize["bs_992"] = "992x280";
    EBannerSize["bs_1200"] = "1200x280";
})(EBannerSize || (EBannerSize = {}));
var EAuthRegister;
(function (EAuthRegister) {
    EAuthRegister[EAuthRegister["Auth"] = 1] = "Auth";
    EAuthRegister[EAuthRegister["Register"] = 2] = "Register";
})(EAuthRegister || (EAuthRegister = {}));
const Banner = ({}) => {
    const [width, setWidth] = React.useState(0);
    const [banner, setBanner] = React.useState(null);
    const [selectedSize, setSelectedSize] = React.useState();
    // key = 1 Auth
    // key = 2 Register
    const [authOrRegister, setAuthOrRegister] = React.useState(EAuthRegister.Auth);
    const [authModalIsOpen, setAuthModalIsOpen] = React.useState(false);
    const userCtx = React.useContext(PageLayout_1.UserContext);
    const resizeWindow = React.useCallback(() => {
        setWidth(window.innerWidth);
    }, []);
    const handleOpenAuthModal = () => {
        setAuthOrRegister(EAuthRegister.Auth);
        setAuthModalIsOpen(true);
    };
    const handleColseAuthModal = () => {
        setAuthModalIsOpen(false);
    };
    React.useEffect(() => {
        let bannerObj;
        switch (true) {
            case width >= 1200:
                bannerObj = banner.images.find(el => el.size === EBannerSize.bs_1200);
                break;
            case width >= 992:
                bannerObj = banner.images.find(el => el.size === EBannerSize.bs_992);
                break;
            case width >= 768:
                bannerObj = banner.images.find(el => el.size === EBannerSize.bs_768);
                break;
            case width >= 576:
                bannerObj = banner.images.find(el => el.size === EBannerSize.bs_576);
                break;
            case width >= 320:
                bannerObj = banner.images.find(el => el.size === EBannerSize.bs_320);
                break;
            default:
                break;
        }
        if (bannerObj) {
            setSelectedSize(bannerObj);
        }
    }, [width]);
    React.useEffect(() => {
        api_1.getBanners()
            .then(response => {
            const banner = response.data[0];
            if (banner) {
                window.addEventListener('resize', resizeWindow);
                setBanner(banner);
                resizeWindow();
            }
        })
            .catch(err => { });
        return () => {
            window.removeEventListener('resize', resizeWindow);
        };
    }, []);
    const handleBannerClick = (bannerUrl) => {
        if (userCtx.user) {
            if (bannerUrl) {
                document.location.href = bannerUrl;
            }
        }
        else {
            handleOpenAuthModal();
        }
    };
    const bannerUrl = banner && banner.url;
    return selectedSize ? (React.createElement(React.Fragment, null,
        authModalIsOpen && (React.createElement(AuthRegister_1.default, { isOpen: authModalIsOpen, onClose: handleColseAuthModal, defaultTab: authOrRegister })),
        React.createElement("div", { className: "home-banner-wrappper", onClick: () => handleBannerClick(bannerUrl) },
            React.createElement("img", { className: "home-banner-img", src: selectedSize.path })))) : null;
};
exports.default = Banner;
