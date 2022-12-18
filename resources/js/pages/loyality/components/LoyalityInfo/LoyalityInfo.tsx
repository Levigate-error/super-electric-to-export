import * as React from 'react';
import { num2str } from '../../../../utils/utils';
import Modal from '../../../../ui/Modal';

interface ILoyalityInfo {
    points: number;
    position: number;
    toFirtst: number;
}

const LoyalityInfo = ({ points, position, toFirtst }: ILoyalityInfo) => {
    const [photoModalVisibility, setPhotoModalVisibility] = React.useState(false);

    const handleClosePhotoModal = () => setPhotoModalVisibility(false);

    return (
        <div className="loyality-info-wrapper">
            {photoModalVisibility && (
                <Modal isOpen={photoModalVisibility} onClose={handleClosePhotoModal}>
                    <h5>Загрузите фото</h5>
                    <p>
                        Для публикации профиля необходимо{' '}
                        <a className="legrand-text-btn" href="/user/profile">
                            загрузить
                        </a>{' '}
                        Вашу фотографию.
                    </p>
                </Modal>
            )}
            <div className="loyality-info-total-wrapper">
                <span className="total-points">{points}</span>
                <span className="total-text">{` ${num2str(points, ['балл', 'балла', 'баллов'])}`}</span>
            </div>

            {!!points && (
                <div className="loyality-rate-wrapper">
                    <span className="rate-info-row">
                        Вы на <strong>{position}</strong> месте в рейтинге!
                    </span>
                    {toFirtst !== 0 && (
                        <span className="rate-info-text">
                            Зарегистрируйте
                            <strong>{` ${toFirtst} ${num2str(toFirtst, ['код', 'кода', 'кодов'])}, `}</strong>
                            чтобы попасть на первое место
                        </span>
                    )}
                </div>
            )}
        </div>
    );
};

export default LoyalityInfo;
