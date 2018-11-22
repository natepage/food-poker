import React from 'react';
import PropTypes from 'prop-types';
import Button from '@material-ui/core/Button';
import Modal from '@material-ui/core/Modal';
import ResponsiveContainer from './ResponsiveContainer';
import SearchInput from './SearchInput';
import SearchResult from './SearchResult';
import SearchSettings from './SearchSettings';
import compose from 'recompose/compose';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import { searchRestaurant, toggleSettings } from './../redux/actions';
import { withStyles } from '@material-ui/core/styles';

class SearchPage extends React.Component {
    handleModalOnClose = () => {
        if (!this.props.isSettingsValid) {
            return;
        }

        this.props.toggleSettings();
    };

    handleSearch = () => {
        this.props.searchRestaurant({ address: this.props.address })
    };

    render () {
        const { classes, isSearching, isSettingsOpened } = this.props;

        return (
            <div className={classes.root}>
                <Modal open={isSettingsOpened}
                       onClose={this.handleModalOnClose}
                       style={{ alignItems: 'center', display: 'flex', justifyContent: 'center' }}
                >
                    <div className={classes.modalContainer}>
                        <SearchSettings/>
                    </div>
                </Modal>

                <ResponsiveContainer>
                    <SearchInput/>
                    {!isSearching &&
                    <div className={classes.buttonContainer}>
                        <Button variant={"contained"} color={"primary"} onClick={this.handleSearch}>
                            Search
                        </Button>
                    </div>
                    }
                    <SearchResult/>
                </ResponsiveContainer>
            </div>
        );
    }
}

const mapStateToProps = store => ({
    address: store.state.address,
    isSearching: store.state.isSearching,
    isSettingsOpened: store.state.isSettingsOpened,
    isSettingsValid: store.state.settings.isValid
});

const mapDispatchToProps = dispatch => bindActionCreators({ searchRestaurant, toggleSettings }, dispatch);

const styles = theme => ({
    buttonContainer: {
        display: 'flex',
        justifyContent: 'center'
    },
    modalContainer: {
        position: 'absolute',
        backgroundColor: theme.palette.background.paper,
        borderRadius: theme.shape.borderRadius,
        boxShadow: theme.shadows[5],
        outline: 'none'
    },
    root: {
        marginTop: 24
    }
});

SearchPage.propTypes = {
    address: PropTypes.string.isRequired,
    classes: PropTypes.object.isRequired,
    isSearching: PropTypes.bool.isRequired,
    isSettingsOpened: PropTypes.bool.isRequired,
    isSettingsValid: PropTypes.bool.isRequired,
    searchRestaurant: PropTypes.func.isRequired,
    toggleSettings: PropTypes.func.isRequired
};

export default compose(withStyles(styles), connect(mapStateToProps, mapDispatchToProps))(SearchPage);