import * as React from 'react';
import { useState } from 'react';
import Button from '../../../ui/Button';
import Modal from '../../../ui/Modal';
import { publishProfile } from './api';

const btnStyle = {
    marginBottom: 20,
    marginTop: 20,
    fontSize: 12,
};

const Publication = ({ user }) => {
    const [published, setPublished] = useState(user.published);
    const [isLoading, setIsLoading] = useState(false);
    const [photoModalVisibility, setPhotoModalVisibility] = React.useState(false);

    const handlePublish = () => {
        setIsLoading(true);
        !user.photo
            ? setPhotoModalVisibility(true)
            : publishProfile({ published: true })
                  .then(response => {
                      setPublished(true);
                  })
                  .finally(() => {
                      setIsLoading(false);
                  });
    };

    const handleDisablePublish = () => {
        setIsLoading(true);
        publishProfile({ published: false })
            .then(response => {
                setPublished(false);
            })
            .finally(() => {
                setIsLoading(false);
            });
    };

    const handleModalClose = () => {
        setIsLoading(false);
        setPhotoModalVisibility(false);
    };

    return (
        <div className="loyality-info-wrapper">
            {photoModalVisibility && (
                <Modal isOpen={photoModalVisibility} onClose={handleModalClose}>
                    <h5>Загрузите фото</h5>
                    <p>Для публикации профиля необходимо загрузить Вашу фотографию в профиле.</p>
                </Modal>
            )}

            {published ? (
                <React.Fragment>
                    <div className="loyality-publish-wrapper">
                        <span>
                            Ваш профиль опубликован на{' '}
                            <a href="https://legrand.ru/smart-home" target="_blank">
                                https://legrand.ru/smart-home
                            </a>
                        </span>
                    </div>
                    <Button
                        onClick={handleDisablePublish}
                        value="Отменить публикацию"
                        appearance="second"
                        style={btnStyle}
                        isLoading={isLoading}
                        disabled={isLoading}
                    />
                </React.Fragment>
            ) : (
                <React.Fragment>
                    <div className="loyality-publish-wrapper">
                        <span>
                            Опубликуйте свой профиль на{' '}
                            <a href="https://legrand.ru/smart-home" target="_blank">
                                https://legrand.ru/smart-home
                            </a>
                        </span>
                    </div>

                    <Button
                        onClick={handlePublish}
                        isLoading={isLoading}
                        value="Опубликовать"
                        appearance="accent"
                        style={btnStyle}
                        disabled={isLoading}
                    />
                </React.Fragment>
            )}
        </div>
    );
};

export default Publication;
