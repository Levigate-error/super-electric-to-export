import * as React from 'react';
import AuthRegister from "../../../components/AuthRegister";
enum EAuthRegister {
    Auth = 1,
    Register = 2,
}

const Join = props => {
    const [authModalIsOpen, setAuthModalIsOpen] = React.useState(false);
    const [authOrRegister, setAuthOrRegister] = React.useState(EAuthRegister.Auth);

    const handleColseAuthModal = () => setAuthModalIsOpen(false);

    const handleOpenRegisterModal = () => {
        setAuthOrRegister(EAuthRegister.Register);
        setAuthModalIsOpen(true);
    };

    if (!props.user) {
        return <div className="promo-join">
            <h2 className="promo-join__title">регистрируйся и выбирай то, что нужно тебе!</h2>
            {/*<p className="promo-join__subtitle">Зарегистрируйся, выполняй условия акции и получай призы!</p>*/}
            <button onClick={handleOpenRegisterModal} type="button" className="promo-join__btn promo-info__button">
                Зарегистрироваться
            </button>
            {authModalIsOpen && (
                <AuthRegister isOpen={authModalIsOpen} onClose={handleColseAuthModal} defaultTab={authOrRegister}/>
            )}
        </div>
    }
    else
    {
        return <div></div>
    }
};
export default Join;
