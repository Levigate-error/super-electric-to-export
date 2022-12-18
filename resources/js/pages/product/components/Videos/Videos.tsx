import * as React from 'react';
import Modal from '../../../../ui/Modal';

interface IVideos {
    videos: TVideo[];
}

type TVideo = {
    description: string;
    file_link: string;
};

function reducer(state, action) {
    switch (action.type) {
        case 'closeVideo':
            return { ...state, modalIsOpen: false };
        case 'openVideo':
            return {
                ...state,
                modalIsOpen: true,
                selectedVideo: action.payload,
            };
        default:
            throw new Error();
    }
}

function Videos({ videos }: IVideos) {
    const [state, dispatch] = React.useReducer(reducer, {
        modalIsOpen: false,
        selectedVideo: { videoId: null, description: '' },
    });

    const showMVideo = (videoId: string, description: string) => {
        dispatch({ type: 'openVideo', payload: { videoId, description } });
    };

    const closeVideo = () => {
        dispatch({ type: 'closeVideo' });
    };

    const getVideoId = (link: string) => {
        /*
            exapmle: https://www.youtube.com/watch?v=yBSjKe9EJN8&t=13s
            1. .split('/') => watch?v=yBSjKe9EJN8&t=13s
            2. .split('&') => watch?v=yBSjKe9EJN8
            3. .split('=') => yBSjKe9EJN8
        */

        let splitUrlWithId = link.split('/');
        let idWithParams = splitUrlWithId[splitUrlWithId.length - 1];
        let idWithoutParams = idWithParams.split('&')[0];
        let idWithoutPrefix = idWithoutParams.split('=');
        let idWithoutSuffix = idWithoutPrefix[idWithoutPrefix.length - 1].split('?');
        let id = idWithoutSuffix[0];

        return id;
    };

    return (
        <React.Fragment>
            <ul className="video-list">
                <Modal isOpen={state.modalIsOpen} onClose={closeVideo} hiddenHeader={true}>
                    {state.modalIsOpen && (
                        <iframe height="315" src={`https://www.youtube.com/embed/${state.selectedVideo.videoId}`} />
                    )}
                    <span className="video-description">{state.selectedVideo.description}</span>
                </Modal>
                {videos.map((item: TVideo) => {
                    let videoId = getVideoId(item.file_link);

                    return (
                        <li key={item.file_link}>
                            <button className="video-preview" onClick={() => showMVideo(videoId, item.description)}>
                                <img
                                    src={`https://img.youtube.com/vi/${videoId}/sddefault.jpg`}
                                    alt={item.description}
                                />
                                <span className="video-title">{item.description}</span>
                            </button>
                        </li>
                    );
                })}
            </ul>
        </React.Fragment>
    );
}

export default React.memo(Videos);
