using NETCoreProject.Data.Validators;
using System;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations;

namespace NETCoreProject.Models
{
    public class Customer : IEntity
    {
        [Required]
        public int Id { get; set; }

        [Required]
        [StringLength(100, MinimumLength = 2)]
        public string Name { get; set; }

        [Required]
        [DataType(DataType.Date)]
        [DateOlderThanToday]
        public DateTime Birthdate { get; set; }

        [DefaultValue(true)]
        public bool Enabled { get; set; } = true;

        [DataType(DataType.Date)]
        public DateTime? CreatedAt { get; set; }

        [DataType(DataType.Date)]
        public DateTime? UpdatedAt { get; set; }

        [DataType(DataType.Date)]
        public DateTime? DeletedAt { get; set; }
    }
}
