import React, { Component } from "react";
import PropTypes from "prop-types"

export default class RepLogCreator extends Component {
    constructor(props) {
        super(props);
        this.quantity = React.createRef();
        this.selectedItem = React.createRef();
        this.itemOptions = [
            { id: 'cat', text: 'Cat' },
            { id: 'fat_cat', text: 'Big Fat Cat' },
            { id: 'laptop', text: 'My Laptop' },
            { id: 'coffee_cup', text: 'Coffee Cup' },
        ];
        this.handleFormSubmit = this.handleFormSubmit.bind(this);
    }

    handleFormSubmit(event) {
        event.preventDefault();
        const { handleAddRepLog } = this.props;
        const quantity = this.quantity.current;
        const item = this.selectedItem.current;

        handleAddRepLog(item.options[item.selectedIndex].value, quantity.value);
    }

    render() {
        return (
            <form className="form-inline" onSubmit={this.handleFormSubmit}>
                <div className="form-group">
                    <label className="sr-only control-label required" htmlFor="rep_log_item">
                        What did you lift?
                    </label>
                    <select
                        ref={this.selectedItem}
                        required="required"
                        defaultValue="fat_cat"
                        className="form-control"
                    >
                        <option value="">What did you lift?</option>
                        {
                            this.itemOptions.map(option => {
                                return <option value={option.id} key={option.id}>{option.text}</option>
                            })
                        }
                    </select>
                </div>
                {' '}
                <div className="form-group">
                    <label className="sr-only control-label required" htmlFor="rep_log_reps">
                        How many times?
                    </label>
                    <input type="number"
                           ref={this.quantity}
                           required="required"
                           placeholder="How many times?"
                           className="form-control"
                    />
                </div>
                {' '}
                <button type="submit" className="btn btn-primary">I Lifted it!</button>
            </form>
        )
    }
}

RepLogCreator.propTypes = {
    handleAddRepLog: PropTypes.func.isRequired
};