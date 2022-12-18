import * as React from 'react';
import classnames from 'classnames';
import { getList } from './api';
import debounce from '../../utils/debounce.js'
import { reducer, initialState, actionTypes } from './reducer';
import { AutoComplete } from 'antd';
const { Option } = AutoComplete;

interface ICityInput {
    disabled?: boolean;
    tabindex?: number;
    onSelect?: (val: any) => void;
    error?: string | false;
    defaultValue?: TCity;
}

type TCity = {
    id: number;
    title: string;
};

const inputStyle = {
    paddingLeft: 10,
};

const renderOption = (item: any) => {
    return <Option key={item.id}>{item.title}</Option>;
};

const CityInput = ({ disabled = false, tabindex = 0, onSelect, defaultValue, error = false }: ICityInput) => {
    const [{ value, list }, dispatch] = React.useReducer(reducer, initialState);

    React.useEffect(() => {
        defaultValue &&
            dispatch({
                type: actionTypes.SELECT_ITEM,
                payload: {
                    id: defaultValue.id,
                    title: defaultValue.title,
                },
            });
    }, []);

    const delayedQuery = React.useRef(
        debounce(val => {

            getList(val)
                .then(response => {
                    dispatch({
                        type: actionTypes.FETCH_SUCCESS,
                        payload: response.data,
                    });
                })
                .catch(err => {});
        }, 1000),
    ).current;

    const handleChange = val => {
        dispatch({ type: actionTypes.SET_VALUE, payload: val });
        if (value !== '') {
            delayedQuery(val);
        }
    };

    const handleSelectItem = id => {
        const newItem = list && list.find(item => parseInt(item.id) === parseInt(id));

        if (newItem) {
            dispatch({
                type: actionTypes.SELECT_ITEM,
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
                type: actionTypes.SELECT_ITEM,
                payload: {
                    id: parseInt(manually.id),
                    title: manually.title,
                },
            });

            onSelect(manually);
        } else {
            dispatch({ type: actionTypes.SET_VALUE, payload: '' });
        }
    };

    const dataSource = list ? list.map(renderOption) : [];

    return (
        <div
            className={classnames('legrand-input-wrapper with-label', {
                'legrand-input-disabled': disabled,
            })}
        >
            <div className="legrand-input-labels">
                <span className="label-wrapper">Город</span>
                {error && <span className="label-error">{error}</span>}
            </div>
            <AutoComplete
                value={value}
                className="form-control shadow-none legrand-input"
                size="large"
                style={{ width: '100%' }}
                dataSource={dataSource}
                onSelect={handleSelectItem}
                onSearch={handleChange}
                optionLabelProp="text"
                onBlur={handleBlur}
            >
                <input
                    style={inputStyle}
                    type="text"
                    placeholder="Выберите город"
                    value={value}
                    autoComplete="off"
                    onChange={handleChange}
                    name="city"
                    tabIndex={tabindex}
                    required
                />
            </AutoComplete>
        </div>
    );
};

export default React.memo(CityInput);
