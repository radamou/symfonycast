import React from "react";
import PropTypes from "prop-types"

export default function RepLogList(props)
{
    const { highlightedRowId, handleRowClick, repLogs } = props;

    return (
        <tbody>
            {repLogs.map( (repLog) => (
                <tr
                    key={repLog.id}
                    className={highlightedRowId === repLog.id ? 'info' : ''}
                    onClick={() => handleRowClick(repLog.id, event)}
                >
                    <td>{repLog.itemLabel}</td>
                    <td>{repLog.reps}</td>
                    <td>{repLog.totalWeightLifted}</td>
                    <td>...</td>
                </tr>
            ))}
        </tbody>
    )
}


RepLogList.propTypes = {
    highlightedRowId: PropTypes.number,
    handleRowClick: PropTypes.func.isRequired,
    repLogs: PropTypes.array.isRequired
};