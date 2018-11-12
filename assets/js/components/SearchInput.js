import React from 'react';
import PropTypes from 'prop-types';
import PlacesAutocomplete from 'react-places-autocomplete';
import { withStyles } from '@material-ui/core/styles';

const styles = theme => ({
    input: {
        border: 'none',
        borderRadius: 2,
        boxShadow: theme.shadows[2],
        fontSize: 16,
        outline: 'none',
        padding: 16,
        width: '100%'
    },
    root: {
        flexGrow: 1,
        fontFamily: theme.typography.fontFamily,
        position: 'relative'
    },
    suggestionsContainer: {
        boxShadow: theme.shadows[1],
        padding: 16,
        position: 'absolute',
        width: '100%',
        top: 55,
        zIndex: 5000
    }
});

class SearchInput extends React.Component
{
    constructor(props) {
        super(props);
        this.state = { address: '' };
        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(address) {
        this.setState({ address });
    };

    render() {
        return (
            <div className={this.props.classes.root}>
                <PlacesAutocomplete value={this.state.address} onChange={this.handleChange} onSelect={this.handleSelect}>
                    {({ getInputProps, suggestions, getSuggestionItemProps, loading }) => (
                        <div>
                            <input
                                {...getInputProps({
                                    placeholder: 'Search Places ...',
                                    className: this.props.classes.input,
                                })}
                            />
                            {loading && <div>Loading...</div>}
                            {suggestions.length > 0 &&
                            <div className={this.props.classes.suggestionsContainer}>
                                {suggestions.map(suggestion => {
                                    return (
                                        <div {...getSuggestionItemProps(suggestion)}>
                                            <span>{suggestion.description}</span>
                                        </div>
                                    );
                                })}
                            </div>
                            }
                        </div>
                    )}
                </PlacesAutocomplete>
            </div>
        )
    }
}

SearchInput.propTypes = {
    classes: PropTypes.object.isRequired
};

export default withStyles(styles)(SearchInput);