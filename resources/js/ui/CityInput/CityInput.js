"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const classnames_1 = require("classnames");
const api_1 = require("./api");
const lodash_1 = require("lodash");
const reducer_1 = require("./reducer");
const antd_1 = require("antd");
const { Option } = antd_1.AutoComplete;
const inputStyle = {
    paddingLeft: 10,
};
const renderOption = (item) => {
    return React.createElement(Option, { key: item.id }, item.title);
};
const CityInput = ({ disabled = false, tabindex = 0, onSelect, defaultValue, error = false }) => {
    const [{ value, list }, dispatch] = React.useReducer(reducer_1.reducer, reducer_1.initialState);
    React.useEffect(() => {
        defaultValue &&
            dispatch({
                type: reducer_1.actionTypes.SELECT_ITEM,
                payload: {
                    id: defaultValue.id,
                    title: defaultValue.title,
                },
            });
    }, []);
    const delayedQuery = React.useRef(lodash_1.debounce(val => {
        api_1.getList(val)
            .then(response => {
            dispatch({
                type: reducer_1.actionTypes.FETCH_SUCCESS,
                payload: response.data,
            });
        })
            .catch(err => { });
    }, 1000)).current;
    const handleChange = val => {
        dispatch({ type: reducer_1.actionTypes.SET_VALUE, payload: val });
        if (value !== '') {
            delayedQuery(val);
        }
    };
    const handleSelectItem = id => {
        const newItem = list && list.find(item => parseInt(item.id) === parseInt(id));
        if (newItem) {
            dispatch({
                type: reducer_1.actionTypes.SELECT_ITEM,
                payload: {
                    id: parseInt(id),
                    title: newItem.title,
                },
            });
        }
        onSelect(newItem);
    };
    const handleBlur = () => {
        const manually = list.find(item => item.title.toLowerCase() === value.toLowerCase());
        if (manually) {
            dispatch({
                type: reducer_1.actionTypes.SELECT_ITEM,
                payload: {
                    id: parseInt(manually.id),
                    title: manually.title,
                },
            });
            onSelect(manually);
        }
        else {
            dispatch({ type: reducer_1.actionTypes.SET_VALUE, payload: '' });
        }
    };
    const dataSource = list ? list.map(renderOption) : [];
    return (React.createElement("div", { className: classnames_1.default('legrand-input-wrapper with-label', {
            'legrand-input-disabled': disabled,
        }) },
        React.createElement("div", { className: "legrand-input-labels" },
            React.createElement("span", { className: "label-wrapper" }, "\u0413\u043E\u0440\u043E\u0434"),
            error && React.createElement("span", { className: "label-error" }, error)),
        React.createElement(antd_1.AutoComplete, { value: value, className: "form-control shadow-none legrand-input", size: "large", style: { width: '100%' }, dataSource: dataSource, onSelect: handleSelectItem, onSearch: handleChange, optionLabelProp: "text", onBlur: handleBlur },
            React.createElement("input", { style: inputStyle, type: "text", placeholder: "Выберите город", value: value, autoComplete: "off", onChange: handleChange, name: "city", tabIndex: tabindex, required: true }))));
};
exports.default = React.memo(CityInput);
