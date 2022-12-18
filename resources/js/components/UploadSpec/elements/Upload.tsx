import * as React from 'react';
import { Icon } from 'antd';

const uploadInputStyle = {
    display: 'none',
};

interface IUpload {
    uploadSpec: (e: any) => void;
    formatErrors: any[];
    validateFetch: boolean;
    exampleSpec: string;
    validateErrors: any[];
}

const Upload = ({ validateFetch, formatErrors, uploadSpec, exampleSpec, validateErrors }: IUpload) => {
    return (
        <React.Fragment>
            <h3>Загрузить спецификацию</h3>
            <p>Скачайте и заполните шаблон или загрузите готовую спецификацию.</p>

            {exampleSpec && (
                <a href={exampleSpec} className="download-spec-template">
                    <Icon type="download" className="spec-template-i" /> Скачать шаблон спецификации
                </a>
            )}

            {!formatErrors.length && (
                <div className="upload-spec-wrap">
                    {validateFetch ? (
                        <Icon type="loading" className="spec-template-i" />
                    ) : (
                        <label htmlFor="upload-spec-input" className="upload-spec-input-wrapper">
                            <Icon type="paper-clip" className="spec-template-i" /> Загрузить спецификацию
                        </label>
                    )}

                    <input
                        id="upload-spec-input"
                        className="upload-spec-input"
                        type="file"
                        style={uploadInputStyle}
                        onChange={uploadSpec}
                    />
                </div>
            )}

            {!!formatErrors.length && (
                <div className="upload-spec-erros-wrapper">
                    <span className="upload-spec-erros-title">Ошибка валидации</span>
                    {formatErrors.map(err => (
                        <span className="validate-spec-error" key={err}>
                            {err}
                        </span>
                    ))}
                </div>
            )}
            {!!validateErrors.length &&
                validateErrors.map(err => (
                    <div className="upload-spec-erros-wrapper" key={err.text}>
                        <span className="upload-spec-erros-title">Ошибка валидации</span>
                        <span className="upload-spec-format-error-title">{err.text}</span>
                        <span className="validate-spec-format-error" key={err}>
                            {err.additional}
                        </span>
                    </div>
                ))}
        </React.Fragment>
    );
};

export default Upload;
