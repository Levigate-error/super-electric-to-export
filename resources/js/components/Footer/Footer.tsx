import * as React from 'react';
import AnalogSelect from '../SelectionAnalog';
import UploadSpec from '../UploadSpec';
import AuthRegister from '../AuthRegister';
import Feedback from '../Feedback';

interface IFooter {
    user: any;
}

interface IState {
    authModalIsOpen: boolean;
    uploadSpecIsOpen: boolean;
    analogSelectIsOpen: boolean;
    feedbackIsOpen: boolean;
}

const whiteLogoStyle = {
    width: '100%',
};

export class Footer extends React.Component<IFooter, IState> {
    state = {
        analogSelectIsOpen: false,
        uploadSpecIsOpen: false,
        authModalIsOpen: false,
        feedbackIsOpen: false,
    };

    handleToggleAnalogSelect = () => this.setState({ analogSelectIsOpen: !this.state.analogSelectIsOpen });

    handleUploadSpecToggle = () => this.setState({ uploadSpecIsOpen: !this.state.uploadSpecIsOpen });

    handleToggleAuthModal = () => this.setState({ authModalIsOpen: !this.state.authModalIsOpen });

    handleToggleFeedback = () => this.setState({ feedbackIsOpen: !this.state.feedbackIsOpen });

    handleOpenUserProfile = () => {
        const baseUrl = window.location.origin;
        window.location.href = `${baseUrl}/user/profile`;
    };

    handleLogoLink = e => {
        if (typeof window !== 'undefined') {
            window.location.pathname === '/' && e.preventDefault();
        }
    };

    render() {
        const { user } = this.props;
        const { analogSelectIsOpen, uploadSpecIsOpen, authModalIsOpen, feedbackIsOpen } = this.state;

        return (
            <footer className="pt-4  pt-md-5 pb-md-5 border-top">
                <div className="container">
                    <div className="row ">
                        <div className="col-xs-12 col-sm-6 col-md-2 logo-wrapper">
                            <a href="/" onClick={this.handleLogoLink} className="footer-logo-link">
                                <object
                                    className="mb-2 footer-logo-svg"
                                    type="image/svg+xml"
                                    data="/images/super-electrician-white.svg"
                                    style={whiteLogoStyle}
                                >
                                    Your browser does not support SVG
                                </object>
                            </a>
                            <br />
                            <a href="https://legrand.ru" target="_blank" className="footer-logo-link">
                                <object
                                    className="mb-2 footer-logo-svg"
                                    type="image/svg+xml"
                                    data="/images/legrand-logo-white.svg"
                                >
                                    Your browser does not support SVG
                                </object>
                            </a>
                            <small className="d-block mb-3 text-muted">?? Legrand. 2019 - {new Date().getFullYear()}</small>

                            <a href="/????????????????_??????_??????????????????????????.pdf" target="_blank">
                                ???????????????????? ???? ?????????????????? ???????????????????????? ????????????
                            </a>
                        </div>

                        <div className="col-xs-12 col-sm-6 col-md-2 ">
                            <ul className="list-unstyled text-small">
                                <li className="pt-2">
                                    <a href="/project/list">?????? ??????????????</a>
                                </li>
                                <li className="pt-2">
                                    <a href="/catalog">??????????????</a>
                                </li>
                                <li className="pt-2">
                                    <button
                                        className="legrand-footer-text-btn"
                                        onClick={user ? this.handleOpenUserProfile : this.handleToggleAuthModal}
                                    >
                                        ??????????????
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div className="col-xs-12 col-sm-6 col-md-3">
                            <ul className="list-unstyled text-small">
                                {user && (
                                    <li className="pt-2">
                                        <button
                                            className="legrand-footer-text-btn"
                                            onClick={this.handleUploadSpecToggle}
                                        >
                                            ?????????????????? ????????????????????????
                                        </button>
                                    </li>
                                )}
                                <li className="pt-2">
                                    <button className="legrand-footer-text-btn" onClick={this.handleToggleAnalogSelect}>
                                        ???????????? ????????????????
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div className="col-xs-12 col-sm-6 col-md-2 ">
                            <ul className="list-unstyled text-small">
                                <li className="pt-2">
                                    <a href="/news">??????????????</a>
                                </li>
                                {/*<li className="pt-2">*/}
                                {/*    <a href="/test">??????????</a>*/}
                                {/*</li>*/}
                                <li className="pt-2">
                                    <a href="/video">??????????</a>
                                </li>
                                <li className="pt-2">
                                    <a href="/faq">FAQ</a>
                                </li>
                            </ul>
                        </div>

                        <div className="col-xs-12 col-sm-12 col-md-3 pt-sm-1">
                            <span>???????? ??????????????, ?????????????????????? ?????? ??????????????????? ???????????????? ??????.</span>
                            <br />
                            <button
                                type="button"
                                className="btn btn-info mt-3 legrand-button"
                                onClick={this.handleToggleFeedback}
                            >
                                ???????????????? ??????????
                            </button>
                        </div>
                    </div>
                </div>
                {analogSelectIsOpen && (
                    <AnalogSelect onClose={this.handleToggleAnalogSelect} isOpen={analogSelectIsOpen} user={user} />
                )}
                {uploadSpecIsOpen && <UploadSpec onClose={this.handleUploadSpecToggle} isOpen={uploadSpecIsOpen} />}
                {authModalIsOpen && (
                    <AuthRegister isOpen={authModalIsOpen} onClose={this.handleToggleAuthModal} defaultTab={1} />
                )}

                {feedbackIsOpen && (
                    <Feedback isOpen={feedbackIsOpen} onClose={this.handleToggleFeedback} type="common" />
                )}
            </footer>
        );
    }
}

export default Footer;
