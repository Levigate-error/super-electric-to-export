"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const ReactDOM = require("react-dom");
const classnames_1 = require("classnames");
const Icons_1 = require("../Icons/Icons");
const Spinner_1 = require("../../ui/Spinner");
class Dropdown extends React.PureComponent {
    constructor() {
        super(...arguments);
        this.drpodownRef = React.createRef();
        this.state = {
            isOpen: false,
            selectedItem: { id: null, name: '', title: '' },
        };
        this.resetDropdown = () => {
            this.setState({
                selectedItem: { id: null, name: '', title: '' },
                isOpen: false,
            });
        };
        this.toggleValues = () => {
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
        this.hideValues = () => {
            const container = window.document.getElementById('main-container');
            this.setState({ isOpen: false }, () => {
                container.style.minHeight = 'auto';
            });
        };
        this.handleClickOutside = e => {
            const domNode = ReactDOM.findDOMNode(this);
            if (!domNode || !domNode.contains(e.target)) {
                this.setState({
                    isOpen: false,
                });
            }
        };
        this.handleClearValue = e => {
            const { onClear } = this.props;
            e.preventDefault();
            this.setState({ selectedItem: { id: null, name: '', title: '' }, isOpen: false }, () => {
                onClear();
            });
        };
        this.handleClick = item => {
            const { action } = this.props;
            action(item);
            this.setState({ selectedItem: item });
            this.hideValues();
        };
    }
    componentDidMount() {
        typeof window !== 'undefined' && window.addEventListener('click', this.handleClickOutside);
        const { defaultId, defaultName, values } = this.props;
        const defaultVal = values.find(item => {
            return item.id == defaultId;
        });
        let name = false;
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
            icon = React.createElement(Spinner_1.default, null);
        }
        else {
            value =
                (selectedItem.name !== '' && selectedItem.name) ||
                    (selectedItem.title !== '' && selectedItem.title) ||
                    '';
            if (typeof selectedItem.id !== 'number' || disableClear) {
                icon = isOpen ? Icons_1.chevronUp : Icons_1.chevronDown;
            }
            else if (typeof disableClear === 'undefined' || !disableClear) {
                icon = (React.createElement("span", { className: "clear-icon", onClick: this.handleClearValue }, Icons_1.clearIcon));
            }
            else {
                icon = null;
            }
        }
        return (React.createElement("div", { className: "legrand-dropdown" },
            React.createElement("div", { className: classnames_1.default('input-section', {
                    'dropdown-disabled': disabled,
                }), style: style, onClick: this.toggleValues },
                React.createElement("span", { className: "dropdown-text unselectable" }, value || defaultName),
                React.createElement("span", { className: "dropdown-icon" }, icon)),
            React.createElement("div", { className: classnames_1.default('dropdown-values', {
                    'values-hidden': !isOpen,
                }), ref: this.drpodownRef },
                React.createElement("ul", null, values &&
                    values.map(item => {
                        return (React.createElement("li", { key: item.id, onClick: () => this.handleClick(item), className: classnames_1.default('unselectable', {
                                'selected-dropdawn-value': selectedItem.id === item.id,
                            }) }, item.name || item.title));
                    })))));
    }
}
exports.default = Dropdown;
