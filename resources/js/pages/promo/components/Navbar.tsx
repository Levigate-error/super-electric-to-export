import * as React from 'react';
import cn from 'classnames';
import Method from '../../loyality/components/Modal/Method';
import Modal from "../../../ui/Modal";
import Manual from "../../loyality/components/Modal/Manual";
import PersonalInfo from "../../loyality/components/Modal/PersonalInfo";
import Check from "../../loyality/components/Modal/Check";

const Navbar = ({ loggedIn, onRegister }) => {
    const [isOpen, toggleMenu] = React.useState(false);
    const [modalState, setModalState] = React.useState('method');
    const [modalIsOpen, setModalIsOpen] = React.useState(false);

    //const [state, dispatch] = React.useReducer(reducer, initialState);

    // React.useEffect(() => {
    //     dispatch({
    //         type: "set-user-is-auth",
    //         payload: !!(typeof window !== "undefined" && window.__USER__)
    //     });
    // }, []);
    const toggleModal = () => {
        setModalIsOpen(!modalIsOpen);
        setModalState('method');
    };

    return (
        <div className="promo-nav">
            <div className="promo-nav__logo">
                <img src="./images/promo/logo.svg" alt="Лого"/>
            </div>
            <nav>
                <ul className={cn('promo-nav__list', {active: isOpen})}>
                    <li className="promo-nav__item">
                        <a href="#rules" className="promo-nav__link">
                            Правила акции
                        </a>
                    </li>
                    <li className="promo-nav__item">
                        <a href="#prize" className="promo-nav__link">
                            Призы
                        </a>
                    </li>
                    {/*<li className="promo-nav__item">*/}
                    {/*    <a href="#" className="promo-nav__link">*/}
                    {/*        Победители*/}
                    {/*    </a>*/}
                    {/*</li>*/}
                    <li className="promo-nav__item">
                        <a href="#question" className="promo-nav__link">
                            Вопросы-ответы
                        </a>
                    </li>
                    <li className="promo-nav__item">
                      {loggedIn ?
                        <a onClick={onRegister} className="promo-nav__btn--mobile">
                          Зарегистрировать промокод
                        </a>
                          :
                        <a href="/leto_legrand" className="promo-nav__btn--mobile">
                          Зарегистрировать промокод
                        </a>
                      }
                    </li>
                </ul>
            </nav>
          {
            !loggedIn ?
              <a onClick={onRegister} className="promo-nav__btn">
                Зарегистрировать промокод
              </a>
                :
              <a href="/leto_legrand" className="promo-nav__btn">
                Зарегистрировать промокод
              </a>
          }
            <a href="#" onClick={() => toggleMenu(!isOpen)} className="promo-nav__burger burger">
                <span>Выиграй призы</span>
                <div className={cn('burger__icon', {active: isOpen})}></div>
            </a>

            <Modal isOpen={modalIsOpen} onClose={toggleModal}>
                <div className="loyalty__loyalty-modal loyalty-modal pt-4 pb-4">
                    {modalState === 'method' && <Method setModalState={setModalState}/>}
                    {modalState === 'manual' && <Manual setModalState={setModalState}/>}
                    {modalState === 'personalInfo' && <PersonalInfo setModalState={setModalState}/>}
                    {modalState === 'check' && <Check setModalIsOpen={setModalIsOpen}/>}
                </div>
            </Modal>
        </div>

    );
};
export default Navbar;
