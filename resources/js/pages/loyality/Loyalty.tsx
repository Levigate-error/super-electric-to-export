import * as React from 'react';
import PageLayout from '../../components/PageLayout';
import Button from '../../ui/Button';
import Modal from '../../ui/Modal';
import Method from './components/Modal/Method';
import Manual from './components/Modal/Manual';
import Check from './components/Modal/Check';
import PrizeConfirm from './components/Modal/PrizeConfirm';
import PrizeCheck from './components/Modal/PrizeCheck';
import PersonalInfo from './components/Modal/PersonalInfo';
import {getTotalAmount, getUploadedReceipts} from './api';

const Loyalty = () => {

    const [modalState, setModalState] = React.useState('method');
    const [modalIsOpen, setModalIsOpen] = React.useState(false);
    const [prizePoints, setPrizePoints] = React.useState(0);
    const [tableCollapse, setTableCollapse] = React.useState('loyalty__table--collapse');
    const [uploadedReceipts, setUploadedReceipts] = React.useState([]);
    const [uploadedReceiptsStatus, setUploadedReceiptsStatus] = React.useState(false);

    React.useEffect(() => {
        //console.log('check');
        getTotalAmount().then(response => {
            //console.log(response);
            setPrizePoints(response)
        });

        getUploadedReceipts().then(response => {
            setUploadedReceiptsStatus(true)
            setUploadedReceipts(response);

        });

    }, []);

    // const [uploadedReceipts, setUploadedReceipts] = React.useState([
    //     {
    //         fn: 1,
    //         created_at: "Joe",
    //         receipt_datetime: "admin",
    //         review_status: "admin",
    //         lottery_id: "admin"
    //     }
    // ]);

    const RecieptList = props => {

        if (!uploadedReceiptsStatus) {
            return (
                <tr>
                    <td>
                        Идет загрузка чеков
                    </td>
                </tr>
            )
        }

        if (!props.reciepts || props.reciepts.length === 0) {
            return (
                <tr>
                    <td>
                        Пока нет чеков. Добавьте их.
                    </td>
                </tr>
            )
        }

        return props.reciepts.map((reciept, index) => {
            const fn = reciept.fn !== null ? reciept.fn : '-'
            const receipt_datetime = reciept.receipt_datetime !== null ? reciept.receipt_datetime : '-'
            const review_status = reciept.review_status !== null ? reciept.review_status : '-'
            const lottery_id = reciept.lottery_id !== null ? reciept.lottery_id : '-'
            return <tr key={`reciept_${index}`}>
                <td>{lottery_id}</td>
                <td>{receipt_datetime}</td>
                <td>{fn}</td>
                <td>{review_status}</td>
            </tr>
        })
    }

    const toggleTableCollapse = () => {
        if (tableCollapse === 'loyalty__table--collapse') {
            setTableCollapse('')
        } else {
            setTableCollapse('loyalty__table--collapse')
        }
    };
    let tableBtnIconClass = tableCollapse === 'loyalty__table--collapse' ? '' : 'loyalty__text-btn__icon--open';
    let tableBtnText = tableCollapse === 'loyalty__table--collapse' ? 'Показать еще' : 'Скрыть';


    const toggleModal = () => {
        setModalIsOpen(!modalIsOpen);
        setModalState('method');
    };
    const toggleModalPrize = (points) => {
        setPrizePoints(points);
        setModalIsOpen(!modalIsOpen);
        setModalState('prize-confirm');
    };


    // console.log('check');
    // getTotalAmount().then(response => {
    //     console.log(response);
    //     setUploadedReceipts(response)
    // });


    return (
        <div className="loayality container mt-5 mb-5">
            <Modal isOpen={modalIsOpen} onClose={toggleModal}>
                <div className="loyalty__loyalty-modal loyalty-modal pt-4 pb-4">
                    {modalState === 'method' && <Method setModalState={setModalState}/>}
                    {modalState === 'manual' && <Manual setModalState={setModalState}/>}
                    {modalState === 'personalInfo' && <PersonalInfo setModalState={setModalState}/>}
                    {modalState === 'check' && <Check setModalIsOpen={setModalIsOpen}/>}
                    {modalState === 'prize-confirm' &&
                    <PrizeConfirm setModalState={setModalState} prizePoints={prizePoints}/>}
                    {modalState === 'prize-check' && <PrizeCheck setModalIsOpen={setModalIsOpen}/>}
                </div>
            </Modal>
            <div className="row mt-5 justify-content-between">
                <div className="col-12 col-lg-7">
                    <h1 className="loyalty__title">Программа лояльности</h1>
                    <p className="loyalty__desc">
                        Покупай продукцию из новой коллекции Inspiria, копи баллы и выбирай ценные призы от Legrand!
                    </p>
                    <Button value="Загрузить чек" className="px-5" onClick={toggleModal}/>
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
                                Баллов накоплено
                                <span className="loyalty__info__sum">{prizePoints}</span>
                            </h2>
                        </header>
                        <p className="loyalty__info__desc--grey">
                            Регистрируйте новые чеки чтобы заработать больше баллов и выбрать самые ценные призы
                        </p>
                    </article>
                </div>
            </div>
            <div className="row mt-4">
                <div className="col-12 col-lg-8">
                    <h2 className="loyalty__subtitle">Зарегистрированные чеки</h2>
                    <table className={tableCollapse + ' loyalty__table--checks'}>
                        <thead>
                        <tr>
                            <th>№ чека</th>
                            <th>Дата регистрации</th>
                            <th>Баллов</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        <RecieptList reciepts={uploadedReceipts}/>

                        </tbody>
                    </table>
                    <button onClick={toggleTableCollapse} className="loyalty__text-btn">
                        {tableBtnText}
                        <div className={'loyalty__text-btn__icon ' + tableBtnIconClass}></div>
                    </button>
                </div>
            </div>

            <div className="row mt-4">
                <div className="col-12">
                    <h2 className="loyalty__subtitle">Витрина призов</h2>
                    <div className="loyalty__showcase">
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 25 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-1.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Футболка Superelektrik</h4>
                            <p>25 баллов</p>

                            <button onClick={() => toggleModalPrize('25')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                        </div>
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 50 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-2.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Зарядка USB 3in1</h4>
                            <p>50 баллов</p>

                            <button onClick={() => toggleModalPrize('50')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                        </div>
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 90 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-3.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Набор Quteo IP44</h4>
                            <p>90 баллов</p>

                            <button onClick={() => toggleModalPrize('90')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                        </div>
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 100 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-4.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Беспроводная зарядка</h4>
                            <p>100 баллов</p>

                            <button onClick={() => toggleModalPrize('100')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                            <div className="loyalty__showcase__item--help">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fillRule="evenodd" clipRule="evenodd"
                                          d="M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM8.48242 10.8848V11.4727H10.5811V11.124C10.5811 10.9281 10.6403 10.7594 10.7588 10.6182C10.8818 10.4723 11.1826 10.2445 11.6611 9.93457C12.2262 9.57454 12.6364 9.19401 12.8916 8.79297C13.1514 8.38737 13.2812 7.90885 13.2812 7.35742C13.2812 6.58724 12.9919 5.97884 12.4131 5.53223C11.8343 5.08561 11.0368 4.8623 10.0205 4.8623C8.78548 4.8623 7.60059 5.18587 6.46582 5.83301L7.41602 7.69238C8.33659 7.20475 9.14095 6.96094 9.8291 6.96094C10.1071 6.96094 10.3327 7.0179 10.5059 7.13184C10.679 7.24121 10.7656 7.3916 10.7656 7.58301C10.7656 7.82454 10.6836 8.03874 10.5195 8.22559C10.36 8.41243 10.0957 8.62207 9.72656 8.85449C9.26172 9.14616 8.93815 9.44694 8.75586 9.75684C8.57357 10.0622 8.48242 10.4382 8.48242 10.8848ZM8.55078 12.8945C8.30925 13.1224 8.18848 13.446 8.18848 13.8652C8.18848 14.2845 8.31608 14.6081 8.57129 14.8359C8.8265 15.0592 9.17969 15.1709 9.63086 15.1709C10.0684 15.1709 10.4124 15.057 10.6631 14.8291C10.9183 14.6012 11.0459 14.2799 11.0459 13.8652C11.0459 13.4505 10.9229 13.1292 10.6768 12.9014C10.4352 12.6689 10.0866 12.5527 9.63086 12.5527C9.1569 12.5527 8.79688 12.6667 8.55078 12.8945Z"
                                          fill="#E60012"/>
                                </svg>
                                <p>
                                    1. Розетки 2 х 2К+З с защитными шторками - IP 44 - 16 A - 250 В~ (цвет - белый)
                                    2. Выключатель + 2К+З розетка с защитными шторками - IP 44 - 16 A - 250 В~ (цвет -
                                    белый)
                                </p>
                            </div>
                        </div>
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 100 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-5.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Набор автоматов 10А DX3-E </h4>
                            <p>100 баллов</p>

                            <button onClick={() => toggleModalPrize('100')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                            <div className="loyalty__showcase__item--help">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fillRule="evenodd" clipRule="evenodd"
                                          d="M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM8.48242 10.8848V11.4727H10.5811V11.124C10.5811 10.9281 10.6403 10.7594 10.7588 10.6182C10.8818 10.4723 11.1826 10.2445 11.6611 9.93457C12.2262 9.57454 12.6364 9.19401 12.8916 8.79297C13.1514 8.38737 13.2812 7.90885 13.2812 7.35742C13.2812 6.58724 12.9919 5.97884 12.4131 5.53223C11.8343 5.08561 11.0368 4.8623 10.0205 4.8623C8.78548 4.8623 7.60059 5.18587 6.46582 5.83301L7.41602 7.69238C8.33659 7.20475 9.14095 6.96094 9.8291 6.96094C10.1071 6.96094 10.3327 7.0179 10.5059 7.13184C10.679 7.24121 10.7656 7.3916 10.7656 7.58301C10.7656 7.82454 10.6836 8.03874 10.5195 8.22559C10.36 8.41243 10.0957 8.62207 9.72656 8.85449C9.26172 9.14616 8.93815 9.44694 8.75586 9.75684C8.57357 10.0622 8.48242 10.4382 8.48242 10.8848ZM8.55078 12.8945C8.30925 13.1224 8.18848 13.446 8.18848 13.8652C8.18848 14.2845 8.31608 14.6081 8.57129 14.8359C8.8265 15.0592 9.17969 15.1709 9.63086 15.1709C10.0684 15.1709 10.4124 15.057 10.6631 14.8291C10.9183 14.6012 11.0459 14.2799 11.0459 13.8652C11.0459 13.4505 10.9229 13.1292 10.6768 12.9014C10.4352 12.6689 10.0866 12.5527 9.63086 12.5527C9.1569 12.5527 8.79688 12.6667 8.55078 12.8945Z"
                                          fill="#E60012"/>
                                </svg>
                                <p>
                                    1. Розетки 2 х 2К+З с защитными шторками - IP 44 - 16 A - 250 В~ (цвет - белый)
                                    2. Выключатель + 2К+З розетка с защитными шторками - IP 44 - 16 A - 250 В~ (цвет -
                                    белый)
                                </p>
                            </div>
                        </div>

                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 100 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-6.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Набор автоматов 16А DX3-E</h4>
                            <p>100 баллов</p>

                            <button onClick={() => toggleModalPrize('100')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                            <div className="loyalty__showcase__item--help">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fillRule="evenodd" clipRule="evenodd"
                                          d="M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM8.48242 10.8848V11.4727H10.5811V11.124C10.5811 10.9281 10.6403 10.7594 10.7588 10.6182C10.8818 10.4723 11.1826 10.2445 11.6611 9.93457C12.2262 9.57454 12.6364 9.19401 12.8916 8.79297C13.1514 8.38737 13.2812 7.90885 13.2812 7.35742C13.2812 6.58724 12.9919 5.97884 12.4131 5.53223C11.8343 5.08561 11.0368 4.8623 10.0205 4.8623C8.78548 4.8623 7.60059 5.18587 6.46582 5.83301L7.41602 7.69238C8.33659 7.20475 9.14095 6.96094 9.8291 6.96094C10.1071 6.96094 10.3327 7.0179 10.5059 7.13184C10.679 7.24121 10.7656 7.3916 10.7656 7.58301C10.7656 7.82454 10.6836 8.03874 10.5195 8.22559C10.36 8.41243 10.0957 8.62207 9.72656 8.85449C9.26172 9.14616 8.93815 9.44694 8.75586 9.75684C8.57357 10.0622 8.48242 10.4382 8.48242 10.8848ZM8.55078 12.8945C8.30925 13.1224 8.18848 13.446 8.18848 13.8652C8.18848 14.2845 8.31608 14.6081 8.57129 14.8359C8.8265 15.0592 9.17969 15.1709 9.63086 15.1709C10.0684 15.1709 10.4124 15.057 10.6631 14.8291C10.9183 14.6012 11.0459 14.2799 11.0459 13.8652C11.0459 13.4505 10.9229 13.1292 10.6768 12.9014C10.4352 12.6689 10.0866 12.5527 9.63086 12.5527C9.1569 12.5527 8.79688 12.6667 8.55078 12.8945Z"
                                          fill="#E60012"/>
                                </svg>
                                <p>
                                    1. Розетки 2 х 2К+З с защитными шторками - IP 44 - 16 A - 250 В~ (цвет - белый)
                                    2. Выключатель + 2К+З розетка с защитными шторками - IP 44 - 16 A - 250 В~ (цвет -
                                    белый)
                                </p>
                            </div>
                        </div>
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 120 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-7.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Набор "Inspiria"</h4>
                            <p>120 баллов</p>

                            <button onClick={() => toggleModalPrize('120')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                            <div className="loyalty__showcase__item--help">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fillRule="evenodd" clipRule="evenodd"
                                          d="M18 10C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10C2 5.58172 5.58172 2 10 2C14.4183 2 18 5.58172 18 10ZM20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10ZM8.48242 10.8848V11.4727H10.5811V11.124C10.5811 10.9281 10.6403 10.7594 10.7588 10.6182C10.8818 10.4723 11.1826 10.2445 11.6611 9.93457C12.2262 9.57454 12.6364 9.19401 12.8916 8.79297C13.1514 8.38737 13.2812 7.90885 13.2812 7.35742C13.2812 6.58724 12.9919 5.97884 12.4131 5.53223C11.8343 5.08561 11.0368 4.8623 10.0205 4.8623C8.78548 4.8623 7.60059 5.18587 6.46582 5.83301L7.41602 7.69238C8.33659 7.20475 9.14095 6.96094 9.8291 6.96094C10.1071 6.96094 10.3327 7.0179 10.5059 7.13184C10.679 7.24121 10.7656 7.3916 10.7656 7.58301C10.7656 7.82454 10.6836 8.03874 10.5195 8.22559C10.36 8.41243 10.0957 8.62207 9.72656 8.85449C9.26172 9.14616 8.93815 9.44694 8.75586 9.75684C8.57357 10.0622 8.48242 10.4382 8.48242 10.8848ZM8.55078 12.8945C8.30925 13.1224 8.18848 13.446 8.18848 13.8652C8.18848 14.2845 8.31608 14.6081 8.57129 14.8359C8.8265 15.0592 9.17969 15.1709 9.63086 15.1709C10.0684 15.1709 10.4124 15.057 10.6631 14.8291C10.9183 14.6012 11.0459 14.2799 11.0459 13.8652C11.0459 13.4505 10.9229 13.1292 10.6768 12.9014C10.4352 12.6689 10.0866 12.5527 9.63086 12.5527C9.1569 12.5527 8.79688 12.6667 8.55078 12.8945Z"
                                          fill="#E60012"/>
                                </svg>
                                <p>
                                    1. Розетки 2 х 2К+З с защитными шторками - IP 44 - 16 A - 250 В~ (цвет - белый)
                                    2. Выключатель + 2К+З розетка с защитными шторками - IP 44 - 16 A - 250 В~ (цвет -
                                    белый)
                                </p>
                            </div>
                        </div>
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 140 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-8.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Набор "Quteo"</h4>
                            <p>140 баллов</p>

                            <button onClick={() => toggleModalPrize('140')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                        </div>
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 160 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-9.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Набор "Valena Life"</h4>
                            <p>160 баллов</p>

                            <button onClick={() => toggleModalPrize('160')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                        </div>
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 160 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-10.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Набор "Valena Allure"</h4>
                            <p>160 баллов</p>

                            <button onClick={() => toggleModalPrize('160')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                        </div>

                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 180 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-11.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Набор "Plexo"</h4>
                            <p>180 баллов</p>

                            <button onClick={() => toggleModalPrize('180')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                        </div>
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 200 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-12.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Денежный приз на Qiwi-кошелёк</h4>
                            <p>200 баллов</p>

                            <button onClick={() => toggleModalPrize('200')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                        </div>
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 250 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-13.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Набор управления Netatmo белый</h4>
                            <p>250 баллов</p>

                            <button onClick={() => toggleModalPrize('250')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                        </div>
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 250 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-14.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Набор управления Netatmo алюминий</h4>
                            <p>250 баллов</p>

                            <button onClick={() => toggleModalPrize('250')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                        </div>
                        <div
                            className={"loyalty__showcase__item " + (prizePoints >= 300 ? 'loyalty__showcase__item--avaliable' : '')}>
                            <div className="loyalty__showcase__item--image">
                                <img src="./images/loyalty-program/prize-15.png" alt=""
                                     className="promo-collection__img"/>
                            </div>
                            <h4>Источник бесперебойного питания</h4>
                            <p>300 баллов</p>

                            <button onClick={() => toggleModalPrize('300')}
                                    className="loyalty__showcase__item--button">Выбрать
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default PageLayout(Loyalty);
