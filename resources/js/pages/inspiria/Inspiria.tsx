import * as React from 'react';
import PageLayout from '../../components/PageLayout';
import Button from '../../ui/Button';
import Modal from '../../ui/Modal';
import AddReceipt from './components/Modal/AddReceipt/AddReceipt';
import ManualInput from './components/Modal/ManualInput/ManualInput';
import Check from './components/Modal/Check/Check';
import PersonalInfo from './components/Modal/PersonalInfo/PersonalInfo';
import AuthRegister from '../../components/AuthRegister';
import { TModalState } from './types';

enum EAuthRegister {
    Auth = 1,
    Register = 2,
}

const Inspiria = ({ store: { userLoyaltyReceipts, userLoyaltyReceiptsTotalAmount, userLoyalties, userResource } }) => {
    const isLogged = userResource && !Array.isArray(userResource);
    const [authOrRegister, setAuthOrRegister] = React.useState(EAuthRegister.Auth);
    const [authModalIsOpen, setAuthModalIsOpen] = React.useState(false);

    const currentLoyalty = userLoyalties.find(({ title }) => title === 'Inspiria');

    const [modalState, setModalState] = React.useState<TModalState>('addReceipt');

    const [showMore, setShowMore] = React.useState(false);
    const [modalIsOpen, setModalIsOpen] = React.useState(false);
    const toggleModal = () => {
        if (!isLogged) {
            setAuthOrRegister(EAuthRegister.Register);
            setAuthModalIsOpen(true);
        } else {
            setModalIsOpen(!modalIsOpen);
            setModalState('addReceipt');
        }
    };

    const numberOfItems = showMore ? userLoyaltyReceipts.length : 2;

    return (
        <div className="loayality container mt-5 mb-5">
            {authModalIsOpen && (
                <AuthRegister
                    isOpen={authModalIsOpen}
                    onClose={() => setAuthModalIsOpen(false)}
                    defaultTab={authOrRegister}
                />
            )}
            <Modal isOpen={modalIsOpen} onClose={toggleModal}>
                <div className="loyalty__loyalty-modal loyalty-modal pt-4 pb-4">
                    {modalState === 'addReceipt' && <AddReceipt setModalState={setModalState} />}
                    {modalState === 'manual' && <ManualInput setModalState={setModalState} />}
                    {modalState === 'personalInfo' && <PersonalInfo setModalState={setModalState} />}
                    {modalState === 'check' && <Check setModalIsOpen={setModalIsOpen} />}
                </div>
            </Modal>

            <div className="row">
                <div className="col-12 col-lg-5">
                    <h1 className="loyalty__title">Программа лояльности</h1>
                    <p className="loyalty__desc">
                        Покупай продукцию из новой коллекции Inspiria и получи шанс выиграть ценные призы!
                    </p>
                    <Button value="Загрузить чек" className="px-5" onClick={toggleModal} />
                </div>
            </div>
            <div className="row mt-5 justify-content-between">
                <div className="col-12 col-lg-7 col-xl-8">
                    <h2 className="loyalty__subtitle">Призы</h2>
                    <table className="loyalty__table--prize">
                        <thead>
                            <tr>
                                <th>Приз</th>
                                <th></th>
                                <th>Месяц</th>
                                <th>Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            {currentLoyalty &&
                                currentLoyalty.loyalty_user_winnings.map(({ id, title, month, status_for_human }) => (
                                    <tr key={id}>
                                        <td>{title}</td>
                                        <td>
                                            <div>
                                                <a href="#">Как получить?</a>
                                                <p>
                                                    Так как сумма выигрыша более 4000 Рублей, то нам потребуются ваши
                                                    данные для уплаты налогов, вы сможете внести их в личном кабинете.
                                                    После проверки мы свяжемся с вами для уточнения деталей вручения
                                                    приза.
                                                </p>
                                            </div>
                                        </td>
                                        <td>{month}</td>
                                        <td>{status_for_human}</td>
                                        <td>
                                            <button
                                                type="button"
                                                className="active"
                                                onClick={() => {
                                                    setModalState('personalInfo');
                                                    setModalIsOpen(true);
                                                }}
                                            >
                                                Ввести данные
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                            {/* <tr>
                                <td>Набор #1</td>
                                <td>
                                    <div>
                                        <a href="#">Как получить?</a>
                                        <p>
                                            Так как сумма выигрыша более 4000 Рублей, то нам потребуются ваши данные для
                                            уплаты налогов, вы сможете внести их в личном кабинете. После проверки мы
                                            свяжемся с вами для уточнения деталей вручения приза.
                                        </p>
                                    </div>
                                </td>
                                <td>Июль</td>
                                <td>Не получен</td>
                                <td>
                                    <button
                                        type="button"
                                        className="active"
                                        onClick={() => {
                                            setModalState('personalInfo');
                                            setModalIsOpen(true);
                                        }}
                                    >
                                        Ввести данные
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Набор #2</td>
                                <td>
                                    <div>
                                        <a href="#">Как получить?</a>
                                        <p>
                                            Так как сумма выигрыша более 4000 Рублей, то нам потребуются ваши данные для
                                            уплаты налогов, вы сможете внести их в личном кабинете. После проверки мы
                                            свяжемся с вами для уточнения деталей вручения приза.
                                        </p>
                                    </div>
                                </td>
                                <td>Июль</td>
                                <td>Не получен</td>
                                <td>
                                    <button type="button" disabled className="check">
                                        Данные на проверке
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>Набор #3</td>
                                <td>
                                    <div>
                                        <a href="#">Как получить?</a>
                                        <p>
                                            Так как сумма выигрыша более 4000 Рублей, то нам потребуются ваши данные для
                                            уплаты налогов, вы сможете внести их в личном кабинете. После проверки мы
                                            свяжемся с вами для уточнения деталей вручения приза.
                                        </p>
                                    </div>
                                </td>
                                <td>Июль</td>
                                <td>Не получен</td>
                                <td>
                                    <button type="button" disabled className="confirmed">
                                        Данные подтверждены
                                    </button>
                                </td>
                            </tr> */}
                        </tbody>
                    </table>
                </div>
                <div className="col col-lg-5 col-xl-4">
                    <article className="loyalty__info">
                        <header className="loyalty__info__header">
                            <img
                                src="./images/loyalty/superelectric.svg"
                                className="loyalty__info__img"
                                alt="Суперэлектрик"
                            />
                            <h2 className="loyalty__info__title">
                                Зарегистрировано чеков на сумму
                                <span className="loyalty__info__sum">{userLoyaltyReceiptsTotalAmount} ₽</span>
                            </h2>
                        </header>
                        {userLoyaltyReceiptsTotalAmount >= 10000 ? (
                            <p className="loyalty__info__desc">Вы участвуете в розыгрыше!</p>
                        ) : null}
                        <p className="loyalty__info__desc--grey">
                            Региструйте новые чеки чтобы увеличить шансы на выигрыш
                        </p>
                    </article>
                </div>
            </div>
            <div className="row">
                <div className="col-12 col-lg-8">
                    <h2 className="loyalty__subtitle">Зарегистрированные чеки</h2>
                    <table className="loyalty__table--checks">
                        <thead>
                            <tr>
                                <th>№</th>
                                <th>Дата</th>
                                <th>Зарегистрирован</th>
                                <th>Розыгрыш</th>
                                <th>Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            {userLoyaltyReceipts
                                .slice(0, numberOfItems)
                                .map(({ receipt_datetime, lottery_id, review_status, created_at }, i) => (
                                    <tr key={i}>
                                        <td>{i + 1}</td>
                                        <td>{receipt_datetime}</td>
                                        <td>{created_at}</td>
                                        <td>{lottery_id}</td>
                                        <td>{review_status}</td>
                                    </tr>
                                ))}
                        </tbody>
                    </table>
                    {userLoyaltyReceipts.length > 2 && !showMore ? (
                        <button type="button" onClick={() => setShowMore(true)} className="loyalty__text-btn">
                            Показать еще<div className="loyalty__text-btn__icon"></div>
                        </button>
                    ) : null}
                    <Button value="Загрузить чек" className="mt-4 px-5 mb-5" onClick={toggleModal} />
                </div>
            </div>
        </div>
    );
};

export default PageLayout(Inspiria);
