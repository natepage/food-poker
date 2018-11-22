// Validate value is one of given checks
export const validateIn = (value, checks) => {
    checks.forEach(check => {
        if (value === check) {
            return true;
        }
    });

    return false;
};

// Validate value is a number between given min and max
export const validateNumberBetween = (value, min, max) => {
    return value < min || value > max || !/^[0-9]+$/.test(value);
};
