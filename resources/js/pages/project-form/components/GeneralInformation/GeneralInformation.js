"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
const React = require("react");
const antd_1 = require("antd");
const Input_1 = require("../../../../ui/Input");
const AddItem_1 = require("../../../../ui/AddItem");
const Button_1 = require("../../../../ui/Button");
const Dropdown_1 = require("../../../../ui/Dropdown");
const api_1 = require("./api");
const antd_2 = require("antd");
const cardStyle = {
    marginBottom: 20,
};
const saveBtnStyle = {
    float: 'right',
};
const formItemLayout = {
    labelCol: {
        xs: { span: 8 },
        sm: { span: 8 },
    },
    wrapperCol: {
        xs: { span: 16 },
    },
};
class GeneralInformation extends React.Component {
    constructor() {
        super(...arguments);
        this.state = {
            isNewProject: true,
            attributesList: this.props.store.attributes,
            statusesList: this.props.store.statuses,
            id: this.props.store.project.id,
            projectStatusId: this.props.store.project.status.id || 1,
            title: this.props.store.project.title || '',
            address: this.props.store.project.address || '',
            attributes: this.props.store.project.attributes || [],
            selectedAttributes: this.props.store.project.attributes.map(item => item.value.id),
            contacts: !this.props.store.project.contacts || this.props.store.project.contacts.length === 0
                ? [{ id: 1, name: '', phone: '' }]
                : this.props.store.project.contacts,
            isLoading: false,
        };
        this.handleChangeName = e => this.setState({ title: e.target.value });
        this.handleChangeAddress = e => this.setState({ address: e.target.value });
        this.generateContactId = arr => {
            let tmp = 0;
            arr.forEach(item => {
                if (item.id > tmp) {
                    tmp = item.id;
                }
            });
            return tmp + 1;
        };
        this.handleAddContact = () => {
            const { contacts } = this.state;
            this.setState({
                contacts: [...contacts, { id: this.generateContactId(contacts), name: '', phone: '' }],
            });
        };
        this.handleSelectStatus = item => {
            this.setState({ projectStatusId: item.id });
        };
        this.handleChangeContactName = e => {
            const { contacts } = this.state;
            const id = e.target.dataset.id;
            const name = e.target.value;
            const newContacts = contacts.map(item => {
                if (item.id === parseInt(id)) {
                    return Object.assign({}, item, { name });
                }
                else {
                    return item;
                }
            });
            this.setState({ contacts: newContacts });
        };
        this.handleChangeContactPhone = e => {
            const { contacts } = this.state;
            const id = e.target.dataset.id;
            const phone = e.target.value;
            const newContacts = contacts.map(item => {
                if (item.id === parseInt(id)) {
                    return Object.assign({}, item, { phone });
                }
                else {
                    return item;
                }
            });
            this.setState({ contacts: newContacts });
        };
        this.removeContactRow = e => {
            e.preventDefault();
            const { contacts } = this.state;
            const id = e.target.dataset.id;
            const newContacts = contacts.filter(function (item) {
                return item.id !== parseInt(id);
            });
            this.setState({ contacts: newContacts });
        };
        this.checkUnique = arr => arr.filter(function (item, pos) {
            return arr.indexOf(item) == pos;
        });
        this.handleSelectAttribute = item => {
            const { selectedAttributes, attributesList } = this.state;
            const currentAttribute = attributesList.find(attribute => {
                const { values } = attribute;
                return values.some(el => {
                    return el.id === item.id;
                });
            });
            const values = currentAttribute.values.map(item => item.id);
            const newAttributesArray = selectedAttributes.filter(el => {
                return values.indexOf(el) < 0;
            });
            this.setState({
                selectedAttributes: this.checkUnique([...newAttributesArray, item.id]),
            });
        };
        this.openNotificationWithIcon = (type, message, description) => {
            antd_2.notification[type]({
                message,
                description,
                duration: 0,
            });
        };
        this.handleUpdateProject = e => {
            e.preventDefault();
            const { id, title, address, selectedAttributes, projectStatusId, contacts } = this.state;
            this.setState({ isLoading: true });
            api_1.updateProject({
                id,
                title,
                address,
                project_status_id: projectStatusId,
                contacts: contacts.map(el => ({ name: el.name, phone: el.phone })),
                attributes: selectedAttributes,
            })
                .then(response => window.location.reload())
                .catch(err => {
                this.setState({ isLoading: false });
                this.openNotificationWithIcon('error', 'Ошибка сохранения информации проекта', '');
            });
        };
    }
    render() {
        const { title, statusesList, attributesList, projectStatusId, address, contacts, attributes, isLoading, } = this.state;
        const statusDefaultValue = projectStatusId
            ? statusesList.find(el => el.id === projectStatusId)
            : statusesList[0];
        return (React.createElement("div", { className: "general-information", onSubmit: this.handleUpdateProject },
            React.createElement(antd_1.Form, Object.assign({}, formItemLayout),
                React.createElement(antd_1.Card, { style: cardStyle },
                    React.createElement(antd_1.Form.Item, { label: "Название проекта" },
                        React.createElement(Input_1.default, { value: title, onChange: this.handleChangeName, required: true })),
                    React.createElement(antd_1.Form.Item, { label: "Адрес" },
                        React.createElement(Input_1.default, { value: address, onChange: this.handleChangeAddress, required: true })),
                    React.createElement(antd_1.Form.Item, { label: "Контакт" },
                        contacts.map((item, i) => (React.createElement("div", { className: "contact-row-wrapepr", key: item.id },
                            React.createElement(Input_1.default, { id: item.id, value: item.name, onChange: this.handleChangeContactName, placeholder: "Имя", required: true }),
                            React.createElement(Input_1.default, { id: item.id, value: item.phone, onChange: this.handleChangeContactPhone, placeholder: "Телефон", type: "number", required: true, icon: i !== 0 && (React.createElement("button", { className: "input-icon-btn", onClick: this.removeContactRow, "data-id": item.id },
                                    React.createElement(antd_1.Icon, { type: "close" }))) })))),
                        React.createElement(AddItem_1.default, { text: "Добавить контакт", action: this.handleAddContact, icon: React.createElement(antd_1.Icon, { type: "plus-square" }) })),
                    React.createElement(antd_1.Form.Item, { label: "Статус" },
                        React.createElement(Dropdown_1.default, { values: statusesList, defaultId: statusDefaultValue.id, defaultName: statusDefaultValue.title, action: this.handleSelectStatus, disableClear: true }))),
                React.createElement(antd_1.Card, { style: cardStyle }, attributesList.map(attribute => {
                    const currentAttribute = attributes.find(attrr => attribute.id === attrr.attribute.id);
                    return (React.createElement(antd_1.Form.Item, { label: attribute.title, key: attribute.id },
                        React.createElement(Dropdown_1.default, { defaultId: currentAttribute && currentAttribute.value.id, defaultName: currentAttribute && currentAttribute.value.title, values: attribute.values, action: this.handleSelectAttribute, disableClear: true })));
                })),
                React.createElement(Button_1.default, { value: "Сохранить", style: saveBtnStyle, type: "submit", isLoading: isLoading }))));
    }
}
exports.GeneralInformation = GeneralInformation;
exports.default = GeneralInformation;
