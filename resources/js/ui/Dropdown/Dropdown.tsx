import * as React from 'react';
import * as ReactDOM from 'react-dom';
import classnames from 'classnames';
import { chevronDown, chevronUp, clearIcon } from '../Icons/Icons';
import Spinner from '../../ui/Spinner';

interface IDropdown {
    values: TValue[];
    isLoading?: boolean;
    defaultName?: string;
    defaultId?: number;
    action: (item: TValue) => void;
    disabled?: boolean;
    onClear?: () => void;
    disableClear?: boolean;
    style?: any;
}

type TValue = {
    id: number;
    name?: string;
    title?: string;
};

interface IState {
    isOpen: boolean;
    selectedItem: TValue;
}

export default class Dropdown extends React.PureComponent<IDropdown, IState> {
    drpodownRef = React.createRef<HTMLDivElement>();

    state = {
        isOpen: false,
        selectedItem: { id: null, name: '', title: '' },
    };

    resetDropdown = () => {
        this.setState({
            selectedItem: { id: null, name: '', title: '' },
            isOpen: false,
        });
    };

    toggleValues = () => {
        const container = window.document.getElementById('main-container');
        const { values, disabled } = this.props;
        const { isOpen } = this.state;

        isOpen
            ? this.setState({ isOpen: false })
            : (values.length > 0 || !disabled) &&
              this.setState({ isOpen: true }, () => {
                  const containerHeight = container.offsetHeight;
                  const valuesHeight = this.drpodownRef.current.offsetHeight;

                  if (containerHeight < valuesHeight + 500) {
                      container.style.minHeight = valuesHeight + 500 + 'px';
                  }
              });
    };

    hideValues = () => {
        const container = window.document.getElementById('main-container');

        this.setState({ isOpen: false }, () => {
            container.style.minHeight = 'auto';
        });
    };

    handleClickOutside = e => {
        const domNode = ReactDOM.findDOMNode(this);

        if (!domNode || !domNode.contains(e.target)) {
            this.setState({
                isOpen: false,
            });
        }
    };

    handleClearValue = e => {
        const { onClear } = this.props;

        e.preventDefault();

        this.setState({ selectedItem: { id: null, name: '', title: '' }, isOpen: false }, () => {
            onClear();
        });
    };

    handleClick = item => {
        const { action } = this.props;
        action(item);
        this.setState({ selectedItem: item });
        this.hideValues();
    };

    componentDidMount() {
        typeof window !== 'undefined' && window.addEventListener('click', this.handleClickOutside);
        const { defaultId, defaultName, values } = this.props;

        const defaultVal = values.find(item => {
            return item.id == defaultId;
        });

        let name: any = false;

        if (defaultVal) {
            name = (defaultVal.name !== '' && defaultVal.name) || (defaultVal.title !== '' && defaultVal.title);
        }
        if (this.props.defaultId && this.props.defaultName) {
            this.setState({
                selectedItem: {
                    id: defaultId,
                    name: name || defaultName,
                    title: name || defaultName,
                },
            });
        }
    }

    componentWillUnmount() {
        document.removeEventListener('click', this.handleClickOutside, false);
    }
    render() {
        const { values, defaultName, disabled, style, isLoading, disableClear } = this.props;
        const { selectedItem, isOpen } = this.state;

        let value = defaultName;
        let icon;
        if (isLoading) {
            icon = <Spinner />;
        } else {
            value =
                (selectedItem.name !== '' && selectedItem.name) ||
                (selectedItem.title !== '' && selectedItem.title) ||
                '';

            if (typeof selectedItem.id !== 'number' || disableClear) {
                icon = isOpen ? chevronUp : chevronDown;
            } else if (typeof disableClear === 'undefined' || !disableClear) {
                icon = (
                    <span className="clear-icon" onClick={this.handleClearValue}>
                        {clearIcon}
                    </span>
                );
            } else {
                icon = null;
            }
        }

        return (
            <div className="legrand-dropdown">
                <div
                    className={classnames('input-section', {
                        'dropdown-disabled': disabled,
                    })}
                    style={style}
                    onClick={this.toggleValues}
                >
                    <span className="dropdown-text unselectable">{value || defaultName}</span>
                    <span className="dropdown-icon">{icon}</span>
                </div>
                <div
                    className={classnames('dropdown-values', {
                        'values-hidden': !isOpen,
                    })}
                    ref={this.drpodownRef}
                >
                    <ul>
                        {values &&
                            values.map(item => {
                                return (
                                    <li
                                        key={item.id}
                                        onClick={() => this.handleClick(item)}
                                        className={classnames('unselectable', {
                                            'selected-dropdawn-value': selectedItem.id === item.id,
                                        })}
                                    >
                                        {item.name || item.title}
                                    </li>
                                );
                            })}
                    </ul>
                </div>
            </div>
        );
    }
}
