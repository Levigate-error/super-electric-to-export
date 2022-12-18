import * as React from 'react';
import { Card, Form, Icon } from 'antd';
import Input from '../../../../ui/Input';
import AddItem from '../../../../ui/AddItem';
import Button from '../../../../ui/Button';
import Dropdown from '../../../../ui/Dropdown';
import { IGeneralInformation } from './types';
import { updateProject } from './api';
import { notification } from 'antd';

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

export class GeneralInformation extends React.Component<IGeneralInformation> {
    state = {
        isNewProject: true,
        attributesList: this.props.store.attributes,
        statusesList: this.props.store.statuses,
        id: this.props.store.project.id,
        projectStatusId: this.props.store.project.status.id || 1,
        title: this.props.store.project.title || '',
        address: this.props.store.project.address || '',
        attributes: this.props.store.project.attributes || [],
        selectedAttributes: this.props.store.project.attributes.map(item => item.value.id),
        contacts:
            !this.props.store.project.contacts || this.props.store.project.contacts.length === 0
                ? [{ id: 1, name: '', phone: '' }]
                : this.props.store.project.contacts,
        isLoading: false,
    };

    handleChangeName = e => this.setState({ title: e.target.value });
    handleChangeAddress = e => this.setState({ address: e.target.value });

    generateContactId = arr => {
        let tmp = 0;
        arr.forEach(item => {
            if (item.id > tmp) {
                tmp = item.id;
            }
        });

        return tmp + 1;
    };

    handleAddContact = () => {
        const { contacts } = this.state;
        this.setState({
            contacts: [...contacts, { id: this.generateContactId(contacts), name: '', phone: '' }],
        });
    };

    handleSelectStatus = item => {
        this.setState({ projectStatusId: item.id });
    };

    handleChangeContactName = e => {
        const { contacts } = this.state;
        const id = e.target.dataset.id;
        const name = e.target.value;

        const newContacts = contacts.map(item => {
            if (item.id === parseInt(id)) {
                return { ...item, name };
            } else {
                return item;
            }
        });
        this.setState({ contacts: newContacts });
    };

    handleChangeContactPhone = e => {
        const { contacts } = this.state;
        const id = e.target.dataset.id;
        const phone = e.target.value;
        const newContacts = contacts.map(item => {
            if (item.id === parseInt(id)) {
                return { ...item, phone };
            } else {
                return item;
            }
        });
        this.setState({ contacts: newContacts });
    };

    removeContactRow = e => {
        e.preventDefault();
        const { contacts } = this.state;
        const id = e.target.dataset.id;
        const newContacts = contacts.filter(function(item) {
            return item.id !== parseInt(id);
        });

        this.setState({ contacts: newContacts });
    };

    checkUnique = arr =>
        arr.filter(function(item, pos) {
            return arr.indexOf(item) == pos;
        });

    handleSelectAttribute = item => {
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

    openNotificationWithIcon = (type, message, description) => {
        notification[type]({
            message,
            description,
            duration: 0,
        });
    };

    handleUpdateProject = e => {
        e.preventDefault();
        const { id, title, address, selectedAttributes, projectStatusId, contacts } = this.state;
        this.setState({ isLoading: true });
        updateProject({
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

    render() {
        const {
            title,
            statusesList,
            attributesList,
            projectStatusId,
            address,
            contacts,
            attributes,
            isLoading,
        } = this.state;

        const statusDefaultValue = projectStatusId
            ? statusesList.find(el => el.id === projectStatusId)
            : statusesList[0];

        return (
            <div className="general-information" onSubmit={this.handleUpdateProject}>
                <Form {...formItemLayout}>
                    <Card style={cardStyle}>
                        <Form.Item label="Название проекта">
                            <Input value={title} onChange={this.handleChangeName} required />
                        </Form.Item>
                        <Form.Item label="Адрес">
                            <Input value={address} onChange={this.handleChangeAddress} required />
                        </Form.Item>
                        <Form.Item label="Контакт">
                            {contacts.map((item, i) => (
                                <div className="contact-row-wrapepr" key={item.id}>
                                    <Input
                                        id={item.id}
                                        value={item.name}
                                        onChange={this.handleChangeContactName}
                                        placeholder="Имя"
                                        required
                                    />

                                    <Input
                                        id={item.id}
                                        value={item.phone}
                                        onChange={this.handleChangeContactPhone}
                                        placeholder="Телефон"
                                        type="number"
                                        required
                                        icon={
                                            i !== 0 && (
                                                <button
                                                    className="input-icon-btn"
                                                    onClick={this.removeContactRow}
                                                    data-id={item.id}
                                                >
                                                    <Icon type="close" />
                                                </button>
                                            )
                                        }
                                    />
                                </div>
                            ))}

                            <AddItem
                                text="Добавить контакт"
                                action={this.handleAddContact}
                                icon={<Icon type="plus-square" />}
                            />
                        </Form.Item>
                        <Form.Item label="Статус">
                            <Dropdown
                                values={statusesList}
                                defaultId={statusDefaultValue.id}
                                defaultName={statusDefaultValue.title}
                                action={this.handleSelectStatus}
                                disableClear
                            />
                        </Form.Item>
                    </Card>
                    <Card style={cardStyle}>
                        {attributesList.map(attribute => {
                            const currentAttribute = attributes.find(attrr => attribute.id === attrr.attribute.id);

                            return (
                                <Form.Item label={attribute.title} key={attribute.id}>
                                    <Dropdown
                                        defaultId={currentAttribute && currentAttribute.value.id}
                                        defaultName={currentAttribute && currentAttribute.value.title}
                                        values={attribute.values}
                                        action={this.handleSelectAttribute}
                                        disableClear={true}
                                    />
                                </Form.Item>
                            );
                        })}
                    </Card>
                    <Button value="Сохранить" style={saveBtnStyle} type="submit" isLoading={isLoading} />
                </Form>
            </div>
        );
    }
}

export default GeneralInformation;
