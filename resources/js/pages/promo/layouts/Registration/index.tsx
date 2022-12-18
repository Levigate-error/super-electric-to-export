import * as React from 'react';

const Registration = ({ loggedIn, onRegister }) => {
    return (
        <div className={!loggedIn ? `registration` : 'registration--none'} >
            <div className="registration_container">
                <div className="registration_title">
                    регистрируйся и выбирай то&nbsp;что нужно тебе!
                </div>
                <button onClick={onRegister} className="registration_btn">Зарегистрироваться</button>
            </div>
        </div>
    )
};

export default Registration;
