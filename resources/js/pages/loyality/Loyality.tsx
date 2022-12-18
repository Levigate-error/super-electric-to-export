import * as React from 'react';
import PageLayout from '../../components/PageLayout';
import { ILoyality } from './types';
import Button from '../../ui/Button';
import Modal from '../../ui/Modal';
import AddCode from './components/AddCode/AddCode';
import { notification } from 'antd';
import { num2str } from '../../utils/utils';
import { UserContext } from '../../components/PageLayout/PageLayout';
import LoyaltyProducts from './components/LoyaltyProducts';
import Info from '../loyality/components/LoyalityInfo/LoyalityInfo';
import AuthRegister from '../../components/AuthRegister';
import { getLoyaltyProposals } from './api';

const addCodeBtnStyle = {
    marginTop: 20,
    marginLeft: 45,
};

interface IState {}

enum EAuthRegister {
    Auth = 1,
    Register = 2,
}

export class Loyality extends React.Component<ILoyality, IState> {
    state = {
        addProductModalIsOpen: false,
        authModalIsOpen: false,
        setAuthOrRegister: EAuthRegister.Auth,
        authOrRegister: EAuthRegister.Register,
        proposals: [],
    };

    openNotificationWithIcon = (type, description) => {
        notification[type]({
            message: 'Загрузка чеков',
            description,
        });
    };
    static contextType = UserContext;

    handleOpenRegisterModal = () => {
        this.setState({ setAuthOrRegister: EAuthRegister.Register });
        this.setState({ authModalIsOpen: true });
    };

    handleOpenAddProductModal = () => this.setState({ addProductModalIsOpen: true });
    handleCloseAddProductModal = () => {
        this.setState({ addProductModalIsOpen: false });
        location.reload();
    };

    handleCloseAuthModal = () => this.setState({ authModalIsOpen: false });

    componentDidMount() {
        getLoyaltyProposals(this.props.store.loyaltyId).then(({ data }) => {
            if (data) {
                this.setState({ proposals: data });
            }
        });
    }

    render() {
        const {
            store: { loyaltyId, userCategories, userLoyalties, userResource },
        } = this.props;

        const isLogged = userResource && !Array.isArray(userResource);
        const currentLoyalty = userLoyalties.find(({ loyalty: { id } }) => id === loyaltyId);

        const { addProductModalIsOpen, authModalIsOpen, authOrRegister, proposals } = this.state;

        return (
            <div className="container mt-4 mb-3 loyality-wrapper" key="container">
                {authModalIsOpen && (
                    <AuthRegister
                        isOpen={authModalIsOpen}
                        onClose={this.handleCloseAuthModal}
                        defaultTab={authOrRegister}
                    />
                )}
                {addProductModalIsOpen && (
                    <Modal isOpen={addProductModalIsOpen} onClose={this.handleCloseAddProductModal}>
                        <AddCode
                            mail={this.context.userResource.email}
                            loyaltyId={loyaltyId}
                            close={this.handleCloseAddProductModal}
                        />
                    </Modal>
                )}
                <div className="row">
                    <div className="col-md-12">
                        <h1>Стань СУПЕРЭЛЕКТРИКОМ with Netatmo 2.1</h1>
                        <span>Период проведения акции с 01.06.2021 по 31.12.2021</span>
                    </div>
                </div>
                <div className="row  task-header">
                    <div className="col-md-12">
                        <h3>Всего 3 простых шага:</h3>
                    </div>
                </div>
                <div className="row ">
                    <div className="col-md-12">
                        <div className="loyality-task-wrapper">
                            <div className="loyality-task-header">
                                <div className="task-step">1</div>
                                <span className="task-text">
                                    Приобретайте и устанавливайте продукцию серии Умный дом Legrand.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="row mt-3">
                    <div className="col-md-12">
                        <div className="loyality-task-wrapper">
                            <div className="loyality-task-header">
                                <div className="task-step">2</div>
                                <span className="task-text">
                                    Регистрируйте серийные номера Wi-Fi шлюзов и отдельных устройств Netatmo
                                </span>
                            </div>
                            <span className="loyality-task-detail-text">1 устройство Netatmo = 20 баллов.</span>
                            <br />
                            <span className="loyality-task-detail-text">
                                1 Wi-Fi шлюз = 10 баллов. Wi-Fi шлюзы входят в стартовый пакет умный дом Legrand
                            </span>
                            <br />
                            <span className="loyality-task-detail-text">
                                + за каждое проводное устройство вы получаете 5 баллов дополнительно
                            </span>
                            <br />
                            <span className="loyality-task-detail-text">
                                + за каждое беспроводное устройство вы получаете 1 балл дополнительно
                            </span>
                            <br />
                            {isLogged ? (
                                <React.Fragment>
                                    {currentLoyalty && (
                                        <div className="row pl-4 mt-3">
                                            <div className="col-md-8">
                                                <Info
                                                    points={currentLoyalty.loyalty_points.points}
                                                    position={currentLoyalty.loyalty_points.place}
                                                    toFirtst={currentLoyalty.loyalty_points.points_gap}
                                                />
                                            </div>
                                        </div>
                                    )}

                                    {proposals.length > 0 ? (
                                        <div className="row pl-4 mt-3">
                                            <table className="loyality-table">
                                                <thead>
                                                    <tr>
                                                        <th>№</th>
                                                        <th>Код</th>
                                                        <th>Дата</th>
                                                        <th>Статус</th>
                                                        <th>Баллы</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {proposals.map(
                                                        (
                                                            {
                                                                id,
                                                                code_text,
                                                                created_at,
                                                                status_on_human,
                                                                accrued_points,
                                                            },
                                                            i,
                                                        ) => (
                                                            <tr key={id}>
                                                                <td>{i + 1}</td>
                                                                <td>{code_text}</td>
                                                                <td>{created_at}</td>
                                                                <td>{status_on_human}</td>
                                                                <td>{accrued_points}</td>
                                                            </tr>
                                                        ),
                                                    )}
                                                </tbody>
                                            </table>
                                        </div>
                                    ) : null}
                                    <br />
                                    <Button
                                        style={addCodeBtnStyle}
                                        onClick={this.handleOpenAddProductModal}
                                        value="Зарегистрировать серийный номер"
                                    />
                                </React.Fragment>
                            ) : (
                                <Button
                                    onClick={this.handleOpenRegisterModal}
                                    style={addCodeBtnStyle}
                                    value="Регистрация"
                                />
                            )}
                        </div>
                    </div>
                </div>
                <div className="row mt-3">
                    <div className="col-12">
                        <LoyaltyProducts />
                    </div>
                </div>
                <div className="row mt-3">
                    <div className="col-md-12">
                        <div className="loyality-task-wrapper">
                            <div className="loyality-task-header">
                                <div className="task-step">3</div>
                                <span className="task-text">Копите баллы и обменивайте их на призы и подарки.</span>
                            </div>
                            <span className="loyality-task-detail-text">
                                Список призов и подарков будет определен специальным голосованием, которое будет скоро
                                доступно.
                            </span>
                            <br />
                            <span className="loyality-task-detail-text">
                                После определения списка призов, они станут доступны для обмена.
                            </span>
                        </div>
                    </div>
                </div>
                <div className="row loyality-levels">
                    {userCategories.map((item, i) => (
                        <div className="loyality-level-wrapper flip-card" key={item.id}>
                            <div className="flip-card-inner">
                                <div className="flip-card-back">
                                    <img className="prize-for-level" src={`images/loyalty/prize/temp.png`} />
                                    <span className="level-points">
                                        {item.points} {` ${num2str(item.points, ['балл', 'балла', 'баллов'])}`}
                                    </span>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
                <div className="row mt-3 mb-5">
                    <div className="col-12">
                        Также вы можете стать одним из трех победителей если сможете заработать самое большое количество
                        баллов до 31.12.2021
                        <br />
                        Победители получают на выбор одно из трех устройств Netatmo, при условии накопления более 50
                        баллов.
                        <br />
                        <div className="mt-2">
                            Подробные правила акции{' '}
                            <a className="legrand-text-btn" target="_blank" href="Superelectric with Netatmo21.pdf">
                                здесь
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

export default PageLayout(Loyality);
