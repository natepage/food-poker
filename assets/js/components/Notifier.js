import React from 'react';
import { withSnackbar } from 'notistack';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { removeNotification } from './../redux/actions';

class Notifier extends React.Component
{
    constructor (props) {
        super(props);

        this.state = {
            displayed: []
        }
    }

    render = () => {
        const { notifications } = this.props;

        notifications.map(notification => {
            setTimeout(() => {
                if (this.state.displayed.filter(key => key === notification.key).length > 0) {
                    return;
                }

                this.props.enqueueSnackbar(notification.message, {variant: notification.type});
                this.setState({displayed: [...this.state.displayed, notification.key]});
                this.props.removeNotification(notification.key);
            }, 300);
        });

        return null;
    }
}

const mapStateToProps = (store) => {
    return {
        notifications: store.state.notifications
    }
};

const mapDispatchToProps = (dispatch) => {
    return bindActionCreators({ removeNotification }, dispatch);
};

export default connect(mapStateToProps, mapDispatchToProps)(withSnackbar(Notifier));