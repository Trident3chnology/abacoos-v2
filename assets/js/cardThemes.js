/**
 * Pro-Max Bank Logos & Vector Card Templates (/ui-ux-pro-max)
 * Verified SVG Fill Color Mappings:
 * - BDO -> Deep Navy Blue (tpl-19: 19.svg #00026C)
 * - China Bank -> Bank Red (tpl-17: 17.svg #6D0000)
 * - BPI -> Crimson Red (tpl-67: 67.svg #991111)
 * - Metrobank -> Royal Blue (tpl-70: 70.svg #0E20CA)
 * - PNB -> Deep Navy Blue (tpl-71: 71.svg #050D58)
 * - Security Bank -> Teal Green (tpl-69: 69.svg #11996C)
 * - UnionBank -> Amber Orange (tpl-24: 24.svg #9E5200)
 */
var WEB_ROOT_PATH = (typeof window.WEB_ROOT !== 'undefined') ? window.WEB_ROOT : '/abacoos-v2/';

const BANK_LOGOS = {
    'none': {
        id: 'none',
        name: 'No Logo',
        logoUrl: null,
        logoText: '',
        badgeBg: 'transparent',
        badgeText: 'transparent',
        defaultTemplate: 'default',
        logoFilter: 'none'
    },
    'default': {
        id: 'default',
        name: 'Default Wallet',
        logoUrl: null,
        logoText: 'WALLET',
        badgeBg: 'rgba(45, 76, 200, 0.12)',
        badgeText: '#2D4CC8',
        defaultTemplate: 'default',
        logoFilter: 'none'
    },
    'bdo': {
        id: 'bdo',
        name: 'BDO Unibank',
        logoUrl: WEB_ROOT_PATH + 'assets/bank/bank logo/BDO Unibank Logo.svg',
        logoText: 'BDO',
        defaultTemplate: 'tpl-19', // BDO Deep Navy Blue (19.svg #00026C)
        logoFilter: 'brightness(0) invert(1)'
    },
    'bpi': {
        id: 'bpi',
        name: 'BPI Bank',
        logoUrl: WEB_ROOT_PATH + 'assets/bank/bank logo/BPI Logo.svg',
        logoText: 'BPI',
        defaultTemplate: 'tpl-67', // BPI Crimson Red (67.svg #991111)
        logoFilter: 'brightness(0) invert(1)'
    },
    'chinabank': {
        id: 'chinabank',
        name: 'China Bank',
        logoUrl: WEB_ROOT_PATH + 'assets/bank/bank logo/China Bank Logo.svg',
        logoText: 'CBC',
        defaultTemplate: 'tpl-17', // China Bank Red (17.svg #6D0000)
        logoFilter: 'brightness(0) invert(1)'
    },
    'metrobank': {
        id: 'metrobank',
        name: 'Metrobank',
        logoUrl: WEB_ROOT_PATH + 'assets/bank/bank logo/Metrobank Logo.svg',
        logoText: 'MB',
        defaultTemplate: 'tpl-70', // Metrobank Royal Blue (70.svg #0E20CA)
        logoFilter: 'brightness(0) invert(1)'
    },
    'pnb': {
        id: 'pnb',
        name: 'PNB Bank',
        logoUrl: WEB_ROOT_PATH + 'assets/bank/bank logo/Philippine National Bank Logo.svg',
        logoText: 'PNB',
        defaultTemplate: 'tpl-71', // PNB Deep Navy Blue (71.svg #050D58)
        logoFilter: 'brightness(0) invert(1)'
    },
    'secbank': {
        id: 'secbank',
        name: 'Security Bank',
        logoUrl: WEB_ROOT_PATH + 'assets/bank/bank logo/Security Bank Logo.svg',
        logoText: 'SECB',
        defaultTemplate: 'tpl-69', // Security Bank Teal Green (69.svg #11996C)
        logoFilter: 'brightness(0) invert(1)'
    },
    'unionbank': {
        id: 'unionbank',
        name: 'UnionBank',
        logoUrl: WEB_ROOT_PATH + 'assets/bank/bank logo/UnionBank Logo.svg',
        logoText: 'UB',
        defaultTemplate: 'tpl-24', // UnionBank Amber Orange (24.svg #9E5200)
        logoFilter: 'brightness(0) invert(1)'
    }
};

const CARD_TEMPLATES = {
    'default': {
        id: 'default',
        name: 'Neumorphic Soft',
        bg: '#e6e7ee',
        svgUrl: null,
        textColor: '#0f172a',
        subTextColor: '#64748b',
        shadow: '6px 6px 14px #b8b9be, -6px -6px 14px #ffffff',
        isNeumorphic: true
    },
    // Template Group 1 (bank-template_1)
    'tpl-16': {
        id: 'tpl-16',
        name: 'Obsidian Dark',
        bg: '#000000',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_1/16.svg',
        textColor: '#ffffff',
        subTextColor: '#cbd5e1',
        shadow: '0 12px 28px -6px rgba(15, 23, 42, 0.65)',
        isNeumorphic: false
    },
    'tpl-17': {
        id: 'tpl-17',
        name: 'China Bank Red',
        bg: '#6D0000',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_1/17.svg',
        textColor: '#ffffff',
        subTextColor: '#fca5a5',
        shadow: '0 12px 28px -6px rgba(109, 0, 0, 0.65)',
        isNeumorphic: false
    },
    'tpl-18': {
        id: 'tpl-18',
        name: 'Bronze Gold',
        bg: '#866900',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_1/18.svg',
        textColor: '#ffffff',
        subTextColor: '#fef08a',
        shadow: '0 12px 28px -6px rgba(134, 105, 0, 0.65)',
        isNeumorphic: false
    },
    'tpl-19': {
        id: 'tpl-19',
        name: 'BDO Deep Navy',
        bg: '#00026C',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_1/19.svg',
        textColor: '#ffffff',
        subTextColor: '#93c5fd',
        shadow: '0 12px 28px -6px rgba(0, 2, 108, 0.65)',
        isNeumorphic: false
    },
    'tpl-23': {
        id: 'tpl-23',
        name: 'Slate Grey',
        bg: '#5D5D5D',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_1/23.svg',
        textColor: '#ffffff',
        subTextColor: '#e2e8f0',
        shadow: '0 12px 28px -6px rgba(93, 93, 93, 0.65)',
        isNeumorphic: false
    },
    'tpl-24': {
        id: 'tpl-24',
        name: 'UnionBank Amber Orange',
        bg: '#9E5200',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_1/24.svg',
        textColor: '#ffffff',
        subTextColor: '#ffedd5',
        shadow: '0 12px 28px -6px rgba(158, 82, 0, 0.65)',
        isNeumorphic: false
    },
    'tpl-25': {
        id: 'tpl-25',
        name: 'Dark Teal',
        bg: '#025F59',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_1/25.svg',
        textColor: '#ffffff',
        subTextColor: '#99f6e4',
        shadow: '0 12px 28px -6px rgba(2, 95, 89, 0.65)',
        isNeumorphic: false
    },

    // Template Group 2 (bank-template_2)
    'tpl-26': {
        id: 'tpl-26',
        name: 'Template 26',
        bg: '#1e293b',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_2/26.svg',
        textColor: '#ffffff',
        subTextColor: '#cbd5e1',
        shadow: '0 12px 28px -6px rgba(30, 41, 59, 0.65)',
        isNeumorphic: false
    },
    'tpl-27': {
        id: 'tpl-27',
        name: 'Template 27',
        bg: '#1d4ed8',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_2/27.svg',
        textColor: '#ffffff',
        subTextColor: '#bfdbfe',
        shadow: '0 12px 28px -6px rgba(29, 78, 216, 0.65)',
        isNeumorphic: false
    },
    'tpl-28': {
        id: 'tpl-28',
        name: 'Template 28',
        bg: '#be123c',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_2/28.svg',
        textColor: '#ffffff',
        subTextColor: '#fecdd3',
        shadow: '0 12px 28px -6px rgba(190, 18, 60, 0.65)',
        isNeumorphic: false
    },
    'tpl-29': {
        id: 'tpl-29',
        name: 'Template 29',
        bg: '#047857',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_2/29.svg',
        textColor: '#ffffff',
        subTextColor: '#a7f3d0',
        shadow: '0 12px 28px -6px rgba(4, 120, 87, 0.65)',
        isNeumorphic: false
    },
    'tpl-30': {
        id: 'tpl-30',
        name: 'Template 30',
        bg: '#b45309',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_2/30.svg',
        textColor: '#ffffff',
        subTextColor: '#fef08a',
        shadow: '0 12px 28px -6px rgba(180, 83, 9, 0.65)',
        isNeumorphic: false
    },

    // Template Group 3 (bank-template_3)
    'tpl-66': {
        id: 'tpl-66',
        name: 'Purple Prism',
        bg: '#36048B',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_5/66.svg',
        textColor: '#ffffff',
        subTextColor: '#ddd6fe',
        shadow: '0 12px 28px -6px rgba(54, 4, 139, 0.65)',
        isNeumorphic: false
    },
    'tpl-67': {
        id: 'tpl-67',
        name: 'BPI Crimson Red',
        bg: '#991111',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_5/67.svg',
        textColor: '#ffffff',
        subTextColor: '#fca5a5',
        shadow: '0 12px 28px -6px rgba(153, 17, 17, 0.65)',
        isNeumorphic: false
    },
    'tpl-68': {
        id: 'tpl-68',
        name: 'Olive Gold',
        bg: '#55660A',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_5/68.svg',
        textColor: '#ffffff',
        subTextColor: '#fef08a',
        shadow: '0 12px 28px -6px rgba(85, 102, 10, 0.65)',
        isNeumorphic: false
    },
    'tpl-69': {
        id: 'tpl-69',
        name: 'Security Bank Teal',
        bg: '#11996C',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_5/69.svg',
        textColor: '#ffffff',
        subTextColor: '#a7f3d0',
        shadow: '0 12px 28px -6px rgba(17, 153, 108, 0.65)',
        isNeumorphic: false
    },
    'tpl-70': {
        id: 'tpl-70',
        name: 'Metrobank Royal Blue',
        bg: '#0E20CA',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_5/70.svg',
        textColor: '#ffffff',
        subTextColor: '#93c5fd',
        shadow: '0 12px 28px -6px rgba(14, 32, 202, 0.65)',
        isNeumorphic: false
    },

    // Template Group 4 (bank-template_4)
    'tpl-71': {
        id: 'tpl-71',
        name: 'PNB Deep Navy',
        bg: '#050D58',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_4/71.svg',
        textColor: '#ffffff',
        subTextColor: '#cbd5e1',
        shadow: '0 12px 28px -6px rgba(5, 13, 88, 0.65)',
        isNeumorphic: false
    },
    'tpl-72': {
        id: 'tpl-72',
        name: 'Coffee Brown',
        bg: '#634736',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_4/72.svg',
        textColor: '#ffffff',
        subTextColor: '#fed7aa',
        shadow: '0 12px 28px -6px rgba(99, 71, 54, 0.65)',
        isNeumorphic: false
    },
    'tpl-73': {
        id: 'tpl-73',
        name: 'Deep Cyan',
        bg: '#0C817D',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_4/73.svg',
        textColor: '#ffffff',
        subTextColor: '#99f6e4',
        shadow: '0 12px 28px -6px rgba(12, 129, 125, 0.65)',
        isNeumorphic: false
    },
    'tpl-74': {
        id: 'tpl-74',
        name: 'Template 74',
        bg: '#1e1b4b',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_4/74.svg',
        textColor: '#ffffff',
        subTextColor: '#e0e7ff',
        shadow: '0 12px 28px -6px rgba(30, 27, 75, 0.65)',
        isNeumorphic: false
    },
    'tpl-75': {
        id: 'tpl-75',
        name: 'Template 75',
        bg: '#0f766e',
        svgUrl: WEB_ROOT_PATH + 'assets/bank/bank-template_4/75.svg',
        textColor: '#ffffff',
        subTextColor: '#ccfbf1',
        shadow: '0 12px 28px -6px rgba(15, 118, 110, 0.65)',
        isNeumorphic: false
    }
};

/**
 * Helper to get theme object with fallback to default
 */
function getBankCardTheme(themeKey) {
    if (!themeKey) return { logo: BANK_LOGOS['default'], template: CARD_TEMPLATES['default'] };

    const parts = themeKey.split('_');
    const logoKey = parts[0] || 'default';
    const templateKey = parts[1] || (BANK_LOGOS[logoKey] ? BANK_LOGOS[logoKey].defaultTemplate : 'default');

    const logo = BANK_LOGOS[logoKey] || BANK_LOGOS['default'];
    const template = CARD_TEMPLATES[templateKey] || CARD_TEMPLATES['default'];

    return {
        id: themeKey,
        logo: logo,
        template: template,
        bg: template.bg,
        svgUrl: template.svgUrl,
        textColor: template.textColor,
        subTextColor: template.subTextColor,
        shadow: template.shadow,
        isNeumorphic: template.isNeumorphic,
        logoUrl: logo.logoUrl,
        logoText: logo.logoText,
        logoFilter: logo.logoFilter
    };
}
