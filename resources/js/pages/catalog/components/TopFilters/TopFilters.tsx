import * as React from 'react';
import { ITopFilters } from './types';
import { Menu, Dropdown, Icon } from 'antd';
import classnames from 'classnames';
import Switch from 'react-switch';
import AuthRegister from '../../../../components/AuthRegister';
import { UserContext } from '../../../../components/PageLayout/PageLayout';

import { tilesIcon, tilesIconAccent, listIcon, listIconAccent } from '../../../../ui/Icons/Icons';

interface IState {
    sortASC: boolean;
    authModalIsOpen: boolean;
}

export default class TopFilters extends React.Component<ITopFilters, IState> {
    state = {
        sortASC: true,
        authModalIsOpen: false,
    };

    static contextType = UserContext;

    resetTopFilters = () => {
        this.setState({ sortASC: true });
    };

    handleToggleFavorites = () => {
        const {
            actions: { onToggleFavorites },
        } = this.props;
        onToggleFavorites();
    };

    handleChangeDisplayFormat = () => {
        const {
            actions: { onChangeDisplayFormat },
        } = this.props;
        onChangeDisplayFormat();
    };

    menu = () => {
        const { sortColumn, productsSort } = this.props;

        return (
            <Menu>
                <Menu.Item
                    className={classnames('sort-control-legrand-dropdown-item', {
                        'selected-sort-item': sortColumn === 'recommended_retail_price' && !productsSort,
                    })}
                    onClick={this.props.actions.onSortByPriceDesc}
                >
                    <span className="sort-control-legrand-text-btn">по убыванию цены</span>
                </Menu.Item>
                <Menu.Item
                    className={classnames('sort-control-legrand-dropdown-item', {
                        'selected-sort-item': sortColumn === 'recommended_retail_price' && productsSort,
                    })}
                    onClick={this.props.actions.onSortByPriceAsc}
                >
                    <span className="sort-control-legrand-text-btn">по возрастанию цены</span>
                </Menu.Item>
                <Menu.Item
                    className={classnames('sort-control-legrand-dropdown-item', {
                        'selected-sort-item': sortColumn === 'rank',
                    })}
                    onClick={this.props.actions.onSortByRate}
                >
                    <span className="sort-control-legrand-text-btn">по популярности</span>
                </Menu.Item>
            </Menu>
        );
    };

    render() {
        const { showAsRows, favoritesSelected, sortColumn, productsSort } = this.props;

        let sortText = '';

        if (sortColumn === 'recommended_retail_price') {
            sortText = productsSort ? 'по возрастанию цены' : 'по убыванию цены';
        } else if (sortColumn === 'rank') {
            sortText = 'по популярности';
        }

        return (
            <div className="catalog-top-row mt-3 mt-md-0 ">
                <span className="control sort-control-wrapper">
                    <span>Сортировать:</span>
                    <Dropdown overlay={this.menu}>
                        <span className="legrand-text-btn">
                            {sortText} <Icon type="down" className="sort-control-icon" />
                        </span>
                    </Dropdown>
                </span>
                <AuthRegister
                    wrapped={
                        <label className="control favorites-control-wrapper">
                            <span>Избранное:</span>
                            <Switch
                                onChange={this.handleToggleFavorites}
                                checked={favoritesSelected}
                                offColor="#c7c7c7"
                                onColor="#c7c7c7"
                                offHandleColor="#727272"
                                onHandleColor="#ed1b24"
                                handleDiameter={22}
                                uncheckedIcon={false}
                                checkedIcon={false}
                                height={14}
                                width={46}
                                disabled={!this.context.user}
                            />
                        </label>
                    }
                />
                <span className="control sort-control-wrapper" role="button">
                    <span>Вид:</span>

                    <button
                        className={classnames('show-as-row-btn', { 'show-as-row-btn-disabled': showAsRows })}
                        onClick={this.handleChangeDisplayFormat}
                    >
                        {showAsRows ? listIconAccent : listIcon}
                    </button>
                    <button
                        className={classnames('show-as-row-btn', { 'show-as-row-btn-disabled': !showAsRows })}
                        onClick={this.handleChangeDisplayFormat}
                    >
                        {showAsRows ? tilesIcon : tilesIconAccent}
                    </button>
                </span>
            </div>
        );
    }
}
