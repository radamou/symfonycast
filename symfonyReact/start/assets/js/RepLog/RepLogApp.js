import React, { Component } from "react";
import RepLogs from "./RepLogs";
import PropTypes from "prop-types"
import uuid from 'uuid/v4';

export class RepLogApp extends Component {
    constructor(props) {
        super(props);

        this.state = {
            highlightedRowId: null,
            repLogs: [
                { id: uuid(), reps: 25, itemLabel: 'My Laptop', totalWeightLifted: 112.5 },
                { id: uuid(), reps: 10, itemLabel: 'Big Fat Cat', totalWeightLifted: 180 },
                { id: uuid(), reps: 4, itemLabel: 'Big Fat Cat', totalWeightLifted: 72 }
            ]
        };

        this.handleRowClick = this.handleRowClick.bind(this);
        this.handleAddRepLog = this.handleAddRepLog.bind(this);
    }

    handleRowClick(repLogId) {
        this.setState({highlightedRowId: repLogId})
    }

    handleAddRepLog(itemLabel, quantity) {
        this.setState(prevState => {
            const newRepLog = {
                id: uuid(),
                reps: quantity,
                itemLabel: itemLabel,
                totalWeightLifted: Math.floor(Math.random()*50)
            };

            const newRepLogs = [...prevState.repLogs, newRepLog];

            return {repLogs: newRepLogs};
        });
    }

    render() {

        return <RepLogs
            {...this.state}
            {...this.props}
            handleRowClick={this.handleRowClick}
            handleAddRepLog={this.handleAddRepLog}
        />
    }
}

RepLogs.propTypes = {
    highlightedRowId: PropTypes.number,
    handleRowClick: PropTypes.func.isRequired,
    handleAddRepLog: PropTypes.func.isRequired,
    withHeart: PropTypes.bool,
    repLogs: PropTypes.array.isRequired
};
