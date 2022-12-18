import * as React from 'react';
import { getBanners } from './api';
import AuthRegister from '../../../../components/AuthRegister/AuthRegister';
import { UserContext } from '../../../../components/PageLayout/PageLayout';

interface IBanner {}

enum EBannerSize {
    bs_320 = '320x280',
    bs_576 = '576x280',
    bs_768 = '768x280',
    bs_992 = '992x280',
    bs_1200 = '1200x280',
}

enum EAuthRegister {
    Auth = 1,
    Register = 2,
}

type TBanner = {
    id: number;
    title: string;
    url: string;
    images: TImage[];
};

type TImage = {
    id: number;
    size: string;
    path: string;
};

const Banner = ({}: IBanner) => {
    const [width, setWidth] = React.useState(0);
    const [banner, setBanner] = React.useState<TBanner | null>(null);
    const [selectedSize, setSelectedSize] = React.useState<any>();

    // key = 1 Auth
    // key = 2 Register
    const [authOrRegister, setAuthOrRegister] = React.useState(EAuthRegister.Auth);
    const [authModalIsOpen, setAuthModalIsOpen] = React.useState(false);

    const userCtx: any = React.useContext(UserContext);

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
        getBanners()
            .then(response => {
                const banner = response.data[0];

                if (banner) {
                    window.addEventListener('resize', resizeWindow);
                    setBanner(banner);
                    resizeWindow();
                }
            })
            .catch(err => {});

        return () => {
            window.removeEventListener('resize', resizeWindow);
        };
    }, []);

    const handleBannerClick = (bannerUrl): void => {
        if (userCtx.user) {
            if (bannerUrl) {
                document.location.href = bannerUrl;
            }
        } else {
            handleOpenAuthModal();
        }
    };

    const bannerUrl = banner && banner.url;
    return selectedSize ? (
        <React.Fragment>
            {authModalIsOpen && (
                <AuthRegister isOpen={authModalIsOpen} onClose={handleColseAuthModal} defaultTab={authOrRegister} />
            )}
            <div className="home-banner-wrappper" onClick={() => handleBannerClick(bannerUrl)}>
                <img className="home-banner-img" src={selectedSize.path} />
            </div>
        </React.Fragment>
    ) : null;
};

export default Banner;
