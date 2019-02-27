import React, { Component } from "react";
import RepLogs from "./RepLogs";
import PropTypes from "prop-types"
import { getRepLogs, deleteRepLog , createRepLog } from '../Api/rep_log'

export class RepLogApp extends Component {
    constructor(props) {
        super(props);

        this.state = {
            highlightedRowId: null,
            repLogs: [],
            numberOfHearts: 1,
            isLoaded: false,
            isSavingNewRepLog: false
        };

        this.handleRowClick = this.handleRowClick.bind(this);
        this.handleAddRepLog = this.handleAddRepLog.bind(this);
        this.handleHeartChange = this.handleHeartChange.bind(this);
        this.handleDeleteRepLog = this.handleDeleteRepLog.bind(this);
    }

    componentDidMount() {
        getRepLogs()
            .then((data) => {
                this.setState({
                    repLogs: data,
                    isLoaded: true
                })
            });
    }
    
    handleRowClick(repLogId) {
        this.setState({highlightedRowId: repLogId})
    }

    handleHeartChange(heartAccount) {
        this.setState({numberOfHearts: heartAccount})
    }

    handleAddRepLog(item, quantity) {
        const newRepLog = {
            reps: quantity,
            item: item,
        };

        this.setState({
            isSavingNewRepLog: true
        });

        createRepLog(newRepLog).then(repLog => {
            this.setState(prevState => {
                const newRepLogs = [...prevState.repLogs, repLog];

                return {
                    repLogs: newRepLogs,
                    isSavingNewRepLog: false
                };
            });
        });
    }

    handleDeleteRepLog(id) {
        deleteRepLog(id).then(
            this.setState(prevState => {
                return {repLogs:  prevState.repLogs.filter(repLog => repLog.id !== id)}
            })
        );
    }

    render() {

        return <RepLogs
            {...this.props}
            {...this.state}
            handleRowClick={this.handleRowClick}
            handleAddRepLog={this.handleAddRepLog}
            OnHeartChange={this.handleHeartChange}
            handleDeleteRepLog={this.handleDeleteRepLog}

        />
    }
}

RepLogs.propTypes = {
    highlightedRowId: PropTypes.any,
    handleRowClick: PropTypes.func.isRequired,
    handleAddRepLog: PropTypes.func.isRequired,
    handleDeleteRepLog:PropTypes.func.isRequired,
    withHeart: PropTypes.bool,
    repLogs: PropTypes.array.isRequired,
    numberOfHearts: PropTypes.number.isRequired,
    isLoaded: PropTypes.bool.isRequired,
    isSavingNewRepLog: PropTypes.bool.isRequired
};
