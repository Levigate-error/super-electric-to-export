import * as React from 'react';
import Input from '../../../ui/Input';
import Button from '../../../ui/Button';

interface ISelectScreen {
    changeArticle: (val: string) => void;
    findAnalog: () => void;
    analogNotFound: boolean;
    article: string;
    analogIsLoading: boolean;
}

const SelectScreen = ({ article, changeArticle, analogNotFound, findAnalog, analogIsLoading }: ISelectScreen) => {
    const handleChangeArticle = e => {
        const val = e.target.value;
        changeArticle(val);
    };

    return (
        <div className="selection-analog-wrapper">
            <h2 className="selection-analog-title">Подбор модульного оборудования Legrand по аналогам</h2>
            <div className="selection-analog-description">
                Введите артикул модульного оборудования других производителей
                и программа подберет вам аналог Legrand.
            </div>
            <Input
                value={article}
                onChange={handleChangeArticle}
                label="Артикул"
                className="selection-analog-article-input"
            />
            <Button
                onClick={findAnalog}
                value="Подобрать"
                appearance="accent"
                isLoading={analogIsLoading}
                className="selection-analog-get-analog-btn"
            />
            {analogNotFound && (
                <div className="selection-analog-find-error">
                    Аналоги не найдены. Введите правильный артикул или подберите аналог в нашем{' '}
                    <a href="/catalog" className="legrand-text-btn">
                        Каталоге
                    </a>
                    .
                </div>
            )}
        </div>
    );
};

export default SelectScreen;
